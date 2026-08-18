<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\AppointmentSettingController;
use App\Models\AgentProfile;
use App\Models\AppNotification;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use App\Services\CommissionService;
use App\Services\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    public function index(): Response
    {
        $appointments = Appointment::with(['doctor.specialization', 'agent.user', 'payments' => function ($q) {
                $q->latest();
            }])
            ->orderByDesc('id')
            ->get();

        $stats = ['total' => $appointments->count()];
        foreach (Appointment::STATUSES as $status) {
            $stats[$status] = $appointments->where('status', $status)->count();
        }

        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'stats'        => $stats,
            'statuses'     => Appointment::STATUSES,
            'pageSettings' => app(AppointmentSettingController::class)->currentSettings(),
            'agents'       => AgentProfile::with('user')->active()->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Appointments/Create', [
            'specializations' => \App\Models\DoctorSpecialization::active()->get(['id', 'name']),
            'doctors'     => Doctor::active()->get(['id', 'name', 'consultation_fee', 'doctor_specialization_id'])->map(fn ($d) => [
                'id' => $d->id,
                'name' => $d->name,
                'consultation_fee' => $d->consultation_fee,
                'specialization_id' => $d->doctor_specialization_id,
            ]),
            'agents'      => AgentProfile::with('user')->active()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:30',
            'department'       => 'nullable|string',
            'doctor_id'        => 'nullable|exists:doctors,id',
            'agent_id'         => 'nullable|exists:agent_profiles,id',
            'preferred_doctor' => 'nullable|string',
            'preferred_date'   => 'nullable|string',
            'appointment_date' => 'nullable|date',
            'time_slot'        => 'nullable|string',
            'fee'              => 'nullable|numeric|min:0',
            'payment_status'   => 'nullable|in:unpaid,paid',
            'paid_amount'      => 'nullable|numeric|min:0',
            'payment_method'   => 'nullable|in:cash,bkash,nagad,rocket,card,online',
            'message'          => 'nullable|string',
            'status'           => 'nullable|in:' . implode(',', Appointment::STATUSES),
            'notes'            => 'nullable|string',
        ]);

        $data['status']         = $data['status'] ?? 'pending';
        $data['payment_status'] = $data['payment_status'] ?? 'unpaid';
        $data['source']         = 'admin';
        $data['is_manual']      = true;
        $data['booked_by_user_id'] = $request->user()->id;

        if (!empty($data['phone'])) {
            $patient = Patient::firstOrCreate(
                ['phone' => $data['phone']],
                ['name' => $data['name'], 'email' => $data['email']]
            );
            $data['patient_id'] = $patient->id;
        }

        $appointment = Appointment::create($data);

        // Handle Commission if booked by agent
        if ($appointment->agent_id) {
            CommissionService::handleAppointmentCommission($appointment);
        }

        // Send confirmation SMS
        SmsService::sendAppointmentBookedAlert($appointment);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment): Response
    {
        $appointment->load([
            'doctor.specialization',
            'agent.user',
            'patient',
            'payments',
        ]);

        return Inertia::render('Admin/Appointments/Show', [
            'booking' => $appointment,
        ]);
    }

    public function invoice(Appointment $appointment): Response
    {
        $appointment->load([
            'doctor.specialization',
            'agent.user',
            'patient',
            'payments',
        ]);

        return Inertia::render('Admin/Appointments/Invoice', [
            'booking' => $appointment,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Appointment::STATUSES),
            'notes'  => 'nullable|string',
        ]);

        $previousStatus = $appointment->status;
        $appointment->update($data);

        if ($appointment->doctor_id && $data['status'] !== $previousStatus
            && in_array($data['status'], [Appointment::STATUS_CONFIRMED, Appointment::STATUS_CANCELLED], true)) {
            $label = $data['status'] === Appointment::STATUS_CANCELLED ? 'cancelled' : 'confirmed';
            User::where('doctor_id', $appointment->doctor_id)->pluck('id')->each(fn ($uid) => AppNotification::notify(
                $uid, "appointment.{$label}", "Appointment {$label}",
                "{$appointment->name} — {$appointment->appointment_date?->format('d M')} at {$appointment->time_slot}.",
                route('admin.doctor-dashboard.index')
            ));

            if ($data['status'] === Appointment::STATUS_CONFIRMED) {
                SmsService::sendAppointmentConfirmedAlert($appointment);
            }
        }

        // If completed, credit agent commission if needed
        if ($data['status'] === Appointment::STATUS_COMPLETED && $appointment->agent_id) {
            CommissionService::handleAppointmentCommission($appointment);
        }

        return back()->with('success', 'Appointment status updated.');
    }

    public function updatePayment(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => ['required', 'in:unpaid,paid'],
            'paid_amount'    => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'in:cash,bkash,nagad,rocket,card,online'],
        ]);

        $appointment->update($validated);

        if ($validated['payment_status'] === 'paid' && $appointment->agent_id) {
            CommissionService::handleAppointmentCommission($appointment);
        }

        return back()->with('success', 'Payment details updated successfully.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted.');
    }

    private function departments(): array
    {
        try {
            return Service::active()->get()->map(fn (Service $s) => $s->title)->values()->all();
        } catch (\Throwable) {
            return [];
        }
    }
}
