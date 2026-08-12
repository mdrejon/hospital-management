<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentProfile;
use App\Models\Doctor;
use App\Models\MedicalTest;
use App\Models\MedicalTestBooking;
use App\Models\MedicalTestBookingItem;
use App\Models\Patient;
use App\Services\CommissionService;
use App\Services\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MedicalTestBookingController extends Controller
{
    public function index(Request $request): Response
    {
        $search        = $request->input('search');
        $status        = $request->input('status');
        $paymentStatus = $request->input('payment_status');
        $agentId       = $request->input('agent_id');
        $date          = $request->input('date');

        $query = MedicalTestBooking::with(['agent.user', 'doctor', 'items'])
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('booking_number', 'like', "%{$search}%")
                        ->orWhere('patient_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($paymentStatus, function ($q, $paymentStatus) {
                $q->where('payment_status', $paymentStatus);
            })
            ->when($agentId, function ($q, $agentId) {
                $q->where('agent_id', $agentId);
            })
            ->when($date, function ($q, $date) {
                $q->whereDate('booking_date', $date);
            })
            ->latest();

        $bookings = $query->paginate(15)->withQueryString();

        $stats = [
            'total_bookings'    => MedicalTestBooking::count(),
            'pending_samples'   => MedicalTestBooking::where('status', MedicalTestBooking::STATUS_PENDING)->count(),
            'processing_tests'  => MedicalTestBooking::whereIn('status', [MedicalTestBooking::STATUS_SAMPLE_COLLECTED, MedicalTestBooking::STATUS_PROCESSING])->count(),
            'completed_tests'   => MedicalTestBooking::where('status', MedicalTestBooking::STATUS_COMPLETED)->count(),
            'total_test_amount' => (float) MedicalTestBooking::sum('total_amount'),
            'total_collected'   => (float) MedicalTestBooking::sum('paid_amount'),
        ];

        return Inertia::render('Admin/MedicalTestBookings/Index', [
            'bookings' => $bookings,
            'filters'  => [
                'search'         => $search,
                'status'         => $status,
                'payment_status' => $paymentStatus,
                'agent_id'       => $agentId,
                'date'           => $date,
            ],
            'agents'   => AgentProfile::with('user')->active()->get(),
            'stats'    => $stats,
        ]);
    }

    public function create(): Response
    {
        $tests = MedicalTest::with('category')->active()->get();
        $doctors = Doctor::active()->get(['id', 'name', 'phone'])->map(fn ($d) => [
            'id' => $d->id,
            'name' => $d->name,
            'phone' => $d->phone
        ]);
        $agents = AgentProfile::with('user')->active()->get();
        $patients = Patient::latest()->take(50)->get(['id', 'name', 'phone', 'email', 'gender', 'date_of_birth', 'address']);

        return Inertia::render('Admin/MedicalTestBookings/Create', [
            'tests'    => $tests,
            'doctors'  => $doctors,
            'agents'   => $agents,
            'patients' => $patients,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_id'        => ['nullable', 'exists:patients,id'],
            'doctor_id'         => ['nullable', 'exists:doctors,id'],
            'agent_id'          => ['nullable', 'exists:agent_profiles,id'],
            'patient_name'      => ['required', 'string', 'max:255'],
            'phone'             => ['required', 'string', 'max:30'],
            'email'             => ['nullable', 'email', 'max:255'],
            'gender'            => ['required', 'in:male,female,other'],
            'date_of_birth'     => ['nullable', 'date'],
            'address'           => ['nullable', 'string'],
            'booking_date'      => ['required', 'date'],
            'preferred_date'    => ['nullable', 'date'],
            'test_ids'          => ['required', 'array', 'min:1'],
            'test_ids.*'        => ['required', 'exists:medical_tests,id'],
            'paid_amount'       => ['nullable', 'numeric', 'min:0'],
            'payment_method'    => ['nullable', 'in:cash,bkash,nagad,rocket,card,online'],
            'notes'             => ['nullable', 'string'],
        ]);

        $booking = DB::transaction(function () use ($validated, $request) {
            // Find or create patient if needed
            $patientId = $validated['patient_id'] ?? null;
            if (!$patientId && !empty($validated['phone'])) {
                $existingPatient = Patient::where('phone', $validated['phone'])->first();
                if ($existingPatient) {
                    $patientId = $existingPatient->id;
                } else {
                    $newPatient = Patient::create([
                        'name'    => $validated['patient_name'],
                        'phone'   => $validated['phone'],
                        'email'   => $validated['email'],
                        'gender'  => $validated['gender'],
                        'date_of_birth' => $validated['date_of_birth'],
                        'address' => $validated['address'],
                    ]);
                    $patientId = $newPatient->id;
                }
            }

            // Fetch selected tests
            $tests = MedicalTest::whereIn('id', $validated['test_ids'])->get();

            $subtotal = 0;
            $discountTotal = 0;
            $itemsData = [];

            foreach ($tests as $test) {
                $subtotal += (float) $test->price;
                $itemDiscount = (float) $test->price - (float) $test->final_price;
                $discountTotal += $itemDiscount;

                $itemsData[] = [
                    'medical_test_id' => $test->id,
                    'test_name'       => is_array($test->name) ? ($test->name[config('app.locale')] ?? reset($test->name)) : $test->name,
                    'test_code'       => $test->code,
                    'unit_price'      => (float) $test->price,
                    'discount_amount' => $itemDiscount,
                    'final_price'     => (float) $test->final_price,
                    'status'          => MedicalTestBookingItem::STATUS_PENDING,
                ];
            }

            $totalAmount = $subtotal - $discountTotal;
            $paidAmount  = (float) ($validated['paid_amount'] ?? 0);
            $dueAmount   = max(0, $totalAmount - $paidAmount);

            $paymentStatus = MedicalTestBooking::PAYMENT_UNPAID;
            if ($paidAmount >= $totalAmount && $totalAmount > 0) {
                $paymentStatus = MedicalTestBooking::PAYMENT_PAID;
            } elseif ($paidAmount > 0) {
                $paymentStatus = MedicalTestBooking::PAYMENT_PARTIAL;
            }

            $booking = MedicalTestBooking::create([
                'booking_number'    => MedicalTestBooking::generateNumber(),
                'patient_id'        => $patientId,
                'doctor_id'         => $validated['doctor_id'] ?? null,
                'booked_by_user_id' => $request->user()->id,
                'agent_id'          => $validated['agent_id'] ?? null,
                'patient_name'      => $validated['patient_name'],
                'phone'             => $validated['phone'],
                'email'             => $validated['email'] ?? null,
                'gender'            => $validated['gender'],
                'date_of_birth'     => $validated['date_of_birth'] ?? null,
                'address'           => $validated['address'] ?? null,
                'booking_date'      => $validated['booking_date'],
                'preferred_date'    => $validated['preferred_date'] ?? null,
                'subtotal_amount'   => $subtotal,
                'discount_amount'   => $discountTotal,
                'total_amount'      => $totalAmount,
                'paid_amount'       => $paidAmount,
                'due_amount'        => $dueAmount,
                'payment_status'    => $paymentStatus,
                'payment_method'    => $validated['payment_method'] ?? null,
                'status'            => MedicalTestBooking::STATUS_PENDING,
                'notes'             => $validated['notes'] ?? null,
            ]);

            foreach ($itemsData as $item) {
                $item['medical_test_booking_id'] = $booking->id;
                MedicalTestBookingItem::create($item);
            }

            // Calculate & handle Agent Commission
            if ($booking->agent_id) {
                CommissionService::handleMedicalTestCommission($booking);
            }

            return $booking;
        });

        // Send SMS to Patient
        SmsService::sendMedicalTestBookedAlert($booking);

        return redirect()->route('admin.medical-test-bookings.show', $booking->id)
            ->with('success', 'Medical test booking created successfully.');
    }

    public function show(MedicalTestBooking $medicalTestBooking): Response
    {
        $medicalTestBooking->load([
            'items.medicalTest',
            'agent.user',
            'doctor',
            'patient',
            'bookedBy',
            'commissions',
        ]);

        return Inertia::render('Admin/MedicalTestBookings/Show', [
            'booking' => $medicalTestBooking,
        ]);
    }

    public function updateStatus(Request $request, MedicalTestBooking $medicalTestBooking): RedirectResponse
    {
        $validated = $request->validate([
            'status'               => ['required', 'in:pending,sample_collected,processing,completed,cancelled'],
            'report_delivery_date' => ['nullable', 'date'],
        ]);

        $status = $validated['status'];
        $medicalTestBooking->status = $status;
        if (!empty($validated['report_delivery_date'])) {
            $medicalTestBooking->report_delivery_date = $validated['report_delivery_date'];
        }
        $medicalTestBooking->save();

        // If completed or paid, credit commission if not already credited
        if ($status === MedicalTestBooking::STATUS_COMPLETED && $medicalTestBooking->agent_id) {
            CommissionService::handleMedicalTestCommission($medicalTestBooking);
            SmsService::sendMedicalTestCompletedAlert($medicalTestBooking);
        }

        return back()->with('success', "Booking status updated to {$status}.");
    }

    public function updatePayment(Request $request, MedicalTestBooking $medicalTestBooking): RedirectResponse
    {
        $validated = $request->validate([
            'paid_amount'    => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,bkash,nagad,rocket,card,online'],
        ]);

        $totalAmount = (float) $medicalTestBooking->total_amount;
        $paidAmount  = (float) $validated['paid_amount'];
        $dueAmount   = max(0, $totalAmount - $paidAmount);

        $paymentStatus = MedicalTestBooking::PAYMENT_UNPAID;
        if ($paidAmount >= $totalAmount && $totalAmount > 0) {
            $paymentStatus = MedicalTestBooking::PAYMENT_PAID;
        } elseif ($paidAmount > 0) {
            $paymentStatus = MedicalTestBooking::PAYMENT_PARTIAL;
        }

        $medicalTestBooking->paid_amount    = $paidAmount;
        $medicalTestBooking->due_amount     = $dueAmount;
        $medicalTestBooking->payment_status = $paymentStatus;
        $medicalTestBooking->payment_method = $validated['payment_method'];
        $medicalTestBooking->save();

        if ($paymentStatus === MedicalTestBooking::PAYMENT_PAID && $medicalTestBooking->agent_id) {
            CommissionService::handleMedicalTestCommission($medicalTestBooking);
        }

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function uploadReport(Request $request, MedicalTestBookingItem $item): RedirectResponse
    {
        $request->validate([
            'report_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        if ($request->hasFile('report_file')) {
            if ($item->report_file && Storage::disk('public')->exists($item->report_file)) {
                Storage::disk('public')->delete($item->report_file);
            }

            $path = $request->file('report_file')->store('test-reports', 'public');
            $item->report_file = $path;
            $item->status = MedicalTestBookingItem::STATUS_COMPLETED;
            $item->save();
        }

        return back()->with('success', "Report uploaded for {$item->test_name}.");
    }
}
