<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\GlobalSetting;
use App\Models\MedicalTest;
use App\Models\MedicalTestBooking;
use App\Models\MedicalTestBookingItem;
use App\Models\MedicalTestCategory;
use App\Models\Patient;
use App\Services\CommissionService;
use App\Services\PaymentService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AgentMedicalTestBookingController extends Controller
{
    public function catalog(Request $request): Response
    {
        $agent = $request->user()->agentProfile;
        $categories = MedicalTestCategory::active()->orderBy('sort_order')->get(['id', 'name']);

        $query = MedicalTest::with('category')->active();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name->en', 'like', "%{$search}%")
                  ->orWhere('name->bn', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $tests = $query->orderBy('name->en')->paginate(15)->withQueryString();

        $tests->getCollection()->transform(function ($test) use ($agent) {
            $rate = CommissionService::resolveTestCommissionRate($test, $agent);
            $test->agent_commission_rate = $rate;
            $test->agent_estimated_commission = round((floatval($test->final_price) * $rate) / 100, 2);
            return $test;
        });

        return Inertia::render('Agent/TestsCatalog', [
            'tests'      => $tests,
            'categories' => $categories,
            'agent'      => $agent,
            'filters'    => $request->only(['search', 'category_id']),
        ]);
    }

    public function create(Request $request): Response
    {
        $agent = $request->user()->agentProfile;

        $categories = MedicalTestCategory::with(['tests' => function ($q) {
            $q->active()->orderBy('sort_order');
        }])->active()->get();

        $allTests = MedicalTest::with('category')->active()->get()->map(function ($test) use ($agent) {
            $test->agent_commission_rate = CommissionService::resolveTestCommissionRate($test, $agent);
            return $test;
        });

        $doctors = Doctor::active()->get(['id', 'name'])->map(fn ($d) => [
            'id' => $d->id,
            'name' => $d->name
        ]);
        $paymentSettings = PaymentService::getActiveGateways();

        $maxDiscountPct = (float) GlobalSetting::get('agent_max_discount_pct', 20.00);
        $maxDiscountFixed = (float) GlobalSetting::get('agent_max_discount_fixed', 500.00);

        return Inertia::render('Agent/BookMedicalTest', [
            'categories'       => $categories,
            'allTests'         => $allTests,
            'doctors'          => $doctors,
            'agent'            => $agent,
            'paymentSettings'  => $paymentSettings,
            'maxDiscountPct'   => $maxDiscountPct,
            'maxDiscountFixed' => $maxDiscountFixed,
        ]);
    }

    public function store(Request $request)
    {
        $agent = $request->user()->agentProfile;

        $validated = $request->validate([
            'patient_name'         => ['required', 'string', 'max:255'],
            'phone'                => ['required', 'string', 'max:30'],
            'email'                => ['nullable', 'email', 'max:255'],
            'gender'               => ['required', 'in:male,female,other'],
            'marital_status'       => ['required', 'string'],
            'date_of_birth'        => ['nullable', 'date'],
            'address'              => ['nullable', 'string'],
            'doctor_id'            => ['nullable', 'exists:doctors,id'],
            'booking_date'         => ['required', 'date'],
            'preferred_date'       => ['nullable', 'date'],
            'test_ids'             => ['required', 'array', 'min:1'],
            'test_ids.*'           => ['required', 'exists:medical_tests,id'],
            'notes'                => ['nullable', 'string'],
            'agent_discount_type'  => ['required', 'in:none,percentage,fixed'],
            'agent_discount_value' => ['required_unless:agent_discount_type,none', 'numeric', 'min:0'],
            'item_discounts'       => ['nullable', 'array'],
            'item_discounts.*'     => ['nullable', 'numeric', 'min:0'],
            'payment_type'         => ['required', 'in:without_pay,online'],
            'payment_gateway'      => ['nullable', 'required_if:payment_type,online', 'in:sslcommerz,bkash'],
        ]);

        $booking = DB::transaction(function () use ($validated, $agent, $request) {
            $patient = Patient::firstOrCreate(
                ['phone' => $validated['phone']],
                [
                    'name'           => $validated['patient_name'],
                    'email'          => $validated['email'] ?? null,
                    'gender'         => $validated['gender'],
                    'marital_status' => $validated['marital_status'],
                    'date_of_birth'  => $validated['date_of_birth'] ?? null,
                    'address'        => $validated['address'] ?? null,
                ]
            );

            $tests = MedicalTest::whereIn('id', $validated['test_ids'])->get();

            $subtotal = 0;
            $discountTotal = 0;
            $totalGrossCommission = 0;
            $itemsData = [];

            foreach ($tests as $test) {
                $subtotal += (float) $test->price;
                $discount = (float) $test->price - (float) $test->final_price;
                $discountTotal += $discount;

                $rate = CommissionService::resolveTestCommissionRate($test, $agent);
                $grossCommission = round(((float)$test->final_price * $rate) / 100, 2);
                $totalGrossCommission += $grossCommission;

                // Check if an item-specific agent discount was submitted
                $customItemDiscount = isset($validated['item_discounts'][$test->id])
                    ? min((float)$validated['item_discounts'][$test->id], $grossCommission)
                    : 0.0;

                $itemsData[] = [
                    'medical_test_id'         => $test->id,
                    'test_name'               => is_array($test->name) ? ($test->name[config('app.locale')] ?? reset($test->name)) : $test->name,
                    'test_code'               => $test->code,
                    'unit_price'              => (float) $test->price,
                    'discount_amount'         => $discount,
                    'final_price'             => (float) $test->final_price,
                    'commission_rate'         => $rate,
                    'commission_base_price'   => (float) $test->final_price,
                    'gross_commission_amount' => $grossCommission,
                    'agent_discount_amount'   => $customItemDiscount,
                    'commission_amount'       => max(0, round($grossCommission - $customItemDiscount, 2)),
                    'status'                  => MedicalTestBookingItem::STATUS_PENDING,
                ];
            }

            $totalCatalogAmount = max(0, $subtotal - $discountTotal);

            $agentDiscountType  = $validated['agent_discount_type'] ?? 'none';
            $agentDiscountValue = (float) ($validated['agent_discount_value'] ?? 0);
            $agentDiscountAmount = 0;

            // If item-specific discounts were provided and sum > 0, use their sum
            $sumCustomDiscounts = array_sum($validated['item_discounts'] ?? []);
            if ($sumCustomDiscounts > 0) {
                $agentDiscountAmount = min($sumCustomDiscounts, $totalGrossCommission, $totalCatalogAmount);
            } elseif ($agentDiscountType === 'percentage' && $agentDiscountValue > 0) {
                $maxDiscountFixed = (float) GlobalSetting::get('agent_max_discount_fixed', 500.00);
                $agentDiscountAmount = round($totalCatalogAmount * $agentDiscountValue / 100, 2);
                $agentDiscountAmount = min($agentDiscountAmount, $maxDiscountFixed, $totalGrossCommission);
            } elseif ($agentDiscountType === 'fixed' && $agentDiscountValue > 0) {
                $maxDiscountFixed = (float) GlobalSetting::get('agent_max_discount_fixed', 500.00);
                $agentDiscountAmount = min($agentDiscountValue, $totalCatalogAmount, $maxDiscountFixed, $totalGrossCommission);
            }

            $finalPayable = max(0, $totalCatalogAmount - $agentDiscountAmount);

            $booking = MedicalTestBooking::create([
                'booking_number'                => MedicalTestBooking::generateNumber(),
                'patient_id'                    => $patient->id,
                'doctor_id'                     => $validated['doctor_id'] ?? null,
                'booked_by_user_id'             => $request->user()->id,
                'agent_id'                      => $agent->id,
                'patient_name'                  => $validated['patient_name'],
                'phone'                         => $validated['phone'],
                'email'                         => $validated['email'] ?? null,
                'gender'                        => $validated['gender'],
                'date_of_birth'                 => $validated['date_of_birth'] ?? null,
                'address'                       => $validated['address'] ?? null,
                'booking_date'                  => $validated['booking_date'],
                'preferred_date'                => $validated['preferred_date'] ?? null,
                'subtotal_amount'               => $subtotal,
                'discount_amount'               => $discountTotal,
                'agent_discount_amount'         => $agentDiscountAmount,
                'agent_discount_type'           => $agentDiscountType,
                'agent_discount_value'          => $agentDiscountValue,
                'total_amount'                  => $finalPayable,
                'paid_amount'                   => 0,
                'due_amount'                    => $finalPayable,
                'payment_method'                => $validated['payment_type'] === 'online' ? $validated['payment_gateway'] : 'without_pay',
                'payment_status'                => MedicalTestBooking::PAYMENT_UNPAID,
                'status'                        => MedicalTestBooking::STATUS_PENDING,
                'agent_gross_commission_amount' => $totalGrossCommission,
                'agent_commission_amount'       => max(0, round($totalGrossCommission - $agentDiscountAmount, 2)),
                'notes'                         => $validated['notes'] ?? null,
            ]);

            foreach ($itemsData as $item) {
                $item['medical_test_booking_id'] = $booking->id;
                MedicalTestBookingItem::create($item);
            }

            CommissionService::handleMedicalTestCommission($booking, $agentDiscountAmount);

            return $booking;
        });

        try {
            SmsService::sendMedicalTestBookedAlert($booking);
        } catch (\Throwable $e) {}

        // If online payment is selected and total > 0
        if ($validated['payment_type'] === 'online' && $booking->total_amount > 0) {
            $payment = PaymentService::createPayment(
                $booking,
                $validated['payment_gateway'],
                (float) $booking->total_amount
            );

            $result = PaymentService::processPayment(
                $payment,
                [
                    'name'    => $booking->patient_name,
                    'phone'   => $booking->phone,
                    'email'   => $booking->email,
                    'address' => $booking->address ?? 'Dhaka, Bangladesh',
                ],
                route('agent.bookings.tests')
            );

            if (!empty($result['redirect_url'])) {
                return Inertia::location($result['redirect_url']);
            }
        }

        return redirect()->route('agent.bookings.tests')->with('success', "Medical test booking #{$booking->booking_number} created successfully!");
    }
}
