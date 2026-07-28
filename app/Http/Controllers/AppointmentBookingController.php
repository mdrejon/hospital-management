<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentConfirmationMail;
use App\Mail\AppointmentReceivedAdminMail;
use App\Models\AppNotification;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use App\Services\AppointmentAvailabilityService;
use App\Support\EmailNotificationSettings;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Public-facing booking API + submit handler. Availability is always
 * computed from our own hospital's doctor schedule (AppointmentAvailabilityService) —
 * chambers are informational only and never affect what's bookable here.
 */
class AppointmentBookingController extends Controller
{
    public function __construct(private readonly AppointmentAvailabilityService $availability) {}

    /** GET /appointment/availability?doctor_id= — unavailable dates for the date picker. */
    public function availability(Request $request): JsonResponse
    {
        $request->validate(['doctor_id' => 'required|exists:doctors,id']);

        $doctor = Doctor::findOrFail($request->integer('doctor_id'));

        return response()->json([
            'unavailable_dates' => $this->availability->unavailableDates($doctor),
            'fee'                => $doctor->consultation_fee,
            'window_days'        => AppointmentAvailabilityService::BOOKING_WINDOW_DAYS,
        ]);
    }

    /** GET /appointment/slots?doctor_id=&date= */
    public function slots(Request $request): JsonResponse
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date'      => 'required|date',
        ]);

        $doctor = Doctor::findOrFail($request->integer('doctor_id'));
        $date   = Carbon::parse($request->string('date'));

        return response()->json([
            'slots' => $this->availability->availableSlots($doctor, $date),
        ]);
    }

    /** POST /appointment */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'patient_name'    => 'required|string|max:255',
            'date_of_birth'   => 'nullable|date|before_or_equal:today',
            'gender'          => 'required|in:male,female,other',
            'phone'           => 'required|string|max:30',
            'email'           => 'nullable|email|max:255',
            'address'         => 'nullable|string',
            'appointment_type' => 'required|in:opd,follow_up',
            'doctor_id'       => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot'       => 'required|string',
            'symptoms'        => 'nullable|string',
            'medical_documents'   => 'nullable|array|max:5',
            'medical_documents.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'source'          => 'nullable|in:home,appointment_page,doctor_details_page',
        ]);

        $doctor = Doctor::findOrFail($data['doctor_id']);
        $date   = Carbon::parse($data['appointment_date']);

        if (!$this->availability->isSlotAvailable($doctor, $date, $data['time_slot'])) {
            return back()->withErrors(['time_slot' => 'Sorry, that time slot was just taken. Please choose another.'])->withInput();
        }

        $documentPaths = collect($request->file('medical_documents', []))
            ->filter()
            ->map(fn ($file) => $file->store('appointment-documents', 'public'))
            ->values()
            ->all();

        $appointment = DB::transaction(function () use ($data, $doctor, $date, $documentPaths) {
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

            // Re-check availability inside the transaction to close the race window.
            if (!$this->availability->isSlotAvailable($doctor, $date, $data['time_slot'])) {
                throw new \RuntimeException('slot_taken');
            }

            return Appointment::create([
                'patient_id'        => $patient->id,
                'doctor_id'         => $doctor->id,
                'name'              => $data['patient_name'],
                'email'             => $data['email'] ?? null,
                'phone'             => $data['phone'],
                'appointment_type'  => $data['appointment_type'],
                'preferred_doctor'  => $doctor->name,
                'appointment_date'  => $date->toDateString(),
                'time_slot'         => $data['time_slot'],
                'serial_number'     => $this->availability->nextSerialNumber($doctor, $date),
                'fee'               => $doctor->consultation_fee,
                'symptoms'          => $data['symptoms'] ?? null,
                'document'          => $documentPaths[0] ?? null,
                'documents'         => $documentPaths ?: null,
                'status'            => Appointment::STATUS_PENDING,
                'source'            => $data['source'] ?? 'appointment_page',
                'is_manual'         => false,
            ]);
        });

        $this->notify($appointment, $doctor);

        return back()->with('success', "Thank you! Your appointment request has been received. Your serial number is #{$appointment->serial_number} for {$date->format('d M Y')} at {$appointment->time_slot}. We'll confirm shortly.");
    }

    private function notify(Appointment $appointment, Doctor $doctor): void
    {
        // Email — patient confirmation + admin/operator notice, both best-effort.
        try {
            $emailsEnabled = EmailNotificationSettings::enabled('appointment_email_notifications', true);

            if ($emailsEnabled && $appointment->email) {
                Mail::to($appointment->email)->send(new AppointmentConfirmationMail($appointment));
            }
            if ($emailsEnabled) {
                EmailNotificationSettings::sendToAdmins(
                    fn () => new AppointmentReceivedAdminMail($appointment),
                    'Appointment notification'
                );
            }
        } catch (\Throwable) {
            // Mail not configured — booking still succeeds.
        }

        // In-app notifications for the doctor (if they have a login) and all operators.
        try {
            User::where('doctor_id', $doctor->id)->pluck('id')->each(fn ($id) => AppNotification::notify(
                $id, 'appointment.new', 'New appointment request',
                "{$appointment->name} requested {$appointment->appointment_date->format('d M')} at {$appointment->time_slot}.",
                route('admin.doctor-dashboard.index')
            ));

            $operatorRoleId = Role::where('slug', 'operator')->value('id');
            if ($operatorRoleId) {
                User::where('role_id', $operatorRoleId)->pluck('id')->each(fn ($id) => AppNotification::notify(
                    $id, 'appointment.new', 'New online appointment received',
                    "{$appointment->name} requested Dr. {$doctor->name} on {$appointment->appointment_date->format('d M')} at {$appointment->time_slot}.",
                    route('admin.appointments.index')
                ));
            }
        } catch (\Throwable) {
            // Non-fatal — booking already succeeded.
        }
    }
}
