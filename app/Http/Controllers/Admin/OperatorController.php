<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppNotification;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Services\AppointmentAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class OperatorController extends Controller
{
    public function __construct(private readonly AppointmentAvailabilityService $availability) {}

    /** Operator dashboard — today's appointments, pending requests, confirmed, waiting, completed. */
    public function dashboard(): Response
    {
        $today = today();

        $todayAppointments = Appointment::with('doctor')
            ->whereDate('appointment_date', $today)
            ->orderBy('time_slot')
            ->get();

        return Inertia::render('Admin/Operator/Dashboard', [
            'todayAppointments' => $todayAppointments,
            'stats' => [
                'today'     => $todayAppointments->count(),
                'pending'   => Appointment::where('status', Appointment::STATUS_PENDING)->count(),
                'confirmed' => Appointment::whereDate('appointment_date', $today)->where('status', Appointment::STATUS_CONFIRMED)->count(),
                'waiting'   => Appointment::whereDate('appointment_date', $today)->whereIn('status', [Appointment::STATUS_CHECKED_IN])->count(),
                'completed' => Appointment::whereDate('appointment_date', $today)->where('status', Appointment::STATUS_COMPLETED)->count(),
            ],
        ]);
    }

    /** Manual booking screen for operators — search/register patient, pick doctor/date/slot, generate serial. */
    public function book(): Response
    {
        return Inertia::render('Admin/Operator/Book', [
            'departments' => Service::active()->get(['id', 'title']),
            'doctors'     => Doctor::active()->get(['id', 'name', 'role', 'consultation_fee']),
        ]);
    }

    /** GET /admin/operator/patients/search?q= — by phone or name. */
    public function searchPatients(Request $request): JsonResponse
    {
        $q = trim((string) $request->get('q'));
        if ($q === '') {
            return response()->json(['patients' => []]);
        }

        $patients = Patient::where('phone', 'like', "%{$q}%")
            ->orWhere('name', 'like', "%{$q}%")
            ->orderByDesc('id')
            ->limit(10)
            ->get(['id', 'name', 'phone', 'email', 'date_of_birth', 'gender', 'address']);

        return response()->json(['patients' => $patients]);
    }

    /** GET /admin/operator/doctors?department_id= */
    public function doctorsByDepartment(Request $request): JsonResponse
    {
        $query = Doctor::active();
        if ($request->filled('department_id')) {
            $query->whereHas('services', fn ($q) => $q->where('services.id', $request->integer('department_id')));
        }

        return response()->json([
            'doctors' => $query->get(['id', 'name', 'role', 'consultation_fee']),
        ]);
    }

    /** GET /admin/operator/slots?doctor_id=&date= */
    public function slots(Request $request): JsonResponse
    {
        $request->validate(['doctor_id' => 'required|exists:doctors,id', 'date' => 'required|date']);

        $doctor = Doctor::findOrFail($request->integer('doctor_id'));
        $date   = Carbon::parse($request->string('date'));

        return response()->json(['slots' => $this->availability->availableSlots($doctor, $date)]);
    }

    /** POST /admin/operator/book — confirms immediately (operator-booked, not "pending" like online requests). */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'patient_id'        => 'nullable|exists:patients,id',
            'patient_name'      => 'required|string|max:255',
            'phone'             => 'required|string|max:30',
            'email'             => 'nullable|email|max:255',
            'date_of_birth'     => 'nullable|date|before_or_equal:today',
            'gender'            => 'required|in:male,female,other',
            'address'           => 'nullable|string',
            'appointment_type'  => 'required|in:opd,follow_up',
            'department_id'     => 'nullable|exists:services,id',
            'department'        => 'nullable|string',
            'doctor_id'         => 'required|exists:doctors,id',
            'appointment_date'  => 'required|date',
            'time_slot'         => 'required|string',
            'symptoms'          => 'nullable|string',
        ]);

        $doctor = Doctor::findOrFail($data['doctor_id']);
        $date   = Carbon::parse($data['appointment_date']);

        if (!$this->availability->isSlotAvailable($doctor, $date, $data['time_slot'])) {
            return back()->withErrors(['time_slot' => 'That slot is no longer available. Please pick another.'])->withInput();
        }

        $appointment = DB::transaction(function () use ($data, $doctor, $date) {
            if (!empty($data['patient_id'])) {
                $patient = Patient::findOrFail($data['patient_id']);
                $patient->fill([
                    'name'          => $data['patient_name'],
                    'phone'         => $data['phone'],
                    'email'         => $data['email'] ?? $patient->email,
                    'date_of_birth' => $data['date_of_birth'] ?? $patient->date_of_birth,
                    'gender'        => $data['gender'],
                    'address'       => $data['address'] ?? $patient->address,
                ])->save();
            } else {
                $patient = Patient::firstOrCreate(
                    ['phone' => $data['phone']],
                    ['name' => $data['patient_name']]
                );
                $patient->fill([
                    'name'          => $data['patient_name'],
                    'email'         => $data['email'] ?? $patient->email,
                    'date_of_birth' => $data['date_of_birth'] ?? $patient->date_of_birth,
                    'gender'        => $data['gender'],
                    'address'       => $data['address'] ?? $patient->address,
                ])->save();
            }

            if (!$this->availability->isSlotAvailable($doctor, $date, $data['time_slot'])) {
                throw new \RuntimeException('slot_taken');
            }

            return Appointment::create([
                'patient_id'        => $patient->id,
                'doctor_id'         => $doctor->id,
                'booked_by_user_id' => auth()->id(),
                'name'              => $data['patient_name'],
                'email'             => $data['email'] ?? null,
                'phone'             => $data['phone'],
                'department'        => $data['department'] ?? null,
                'appointment_type'  => $data['appointment_type'],
                'preferred_doctor'  => $doctor->name,
                'appointment_date'  => $date->toDateString(),
                'time_slot'         => $data['time_slot'],
                'serial_number'     => $this->availability->nextSerialNumber($doctor, $date),
                'fee'               => $doctor->consultation_fee,
                'symptoms'          => $data['symptoms'] ?? null,
                'status'            => Appointment::STATUS_CONFIRMED,
                'source'            => 'admin',
                'is_manual'         => true,
            ]);
        });

        $doctorUserIds = \App\Models\User::where('doctor_id', $doctor->id)->pluck('id');
        foreach ($doctorUserIds as $uid) {
            AppNotification::notify(
                $uid, 'appointment.new', 'New appointment assigned',
                "{$appointment->name} — {$appointment->appointment_date->format('d M')} at {$appointment->time_slot} (Serial #{$appointment->serial_number}).",
                route('admin.doctor-dashboard.index')
            );
        }

        return redirect()->route('admin.operator.dashboard')
            ->with('success', "Appointment confirmed — Serial #{$appointment->serial_number} for {$doctor->name} on {$date->format('d M Y')} at {$appointment->time_slot}.");
    }
}
