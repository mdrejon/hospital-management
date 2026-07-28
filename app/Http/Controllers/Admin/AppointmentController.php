<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\AppointmentSettingController;
use App\Models\AppNotification;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    public function index(): Response
    {
        $appointments = Appointment::with('doctor:id,name')->orderByDesc('id')->get();

        $stats = ['total' => $appointments->count()];
        foreach (Appointment::STATUSES as $status) {
            $stats[$status] = $appointments->where('status', $status)->count();
        }

        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'stats'        => $stats,
            'statuses'     => Appointment::STATUSES,
            'pageSettings' => app(AppointmentSettingController::class)->currentSettings(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Appointments/Create', [
            'departments' => $this->departments(),
            'doctors'     => Doctor::active()->pluck('name'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'nullable|string|max:30',
            'department'       => 'nullable|string',
            'preferred_doctor' => 'nullable|string',
            'preferred_date'   => 'nullable|string',
            'message'          => 'nullable|string',
            'status'           => 'nullable|in:' . implode(',', Appointment::STATUSES),
            'notes'            => 'nullable|string',
        ]);

        $data['status']    = $data['status'] ?? 'pending';
        $data['source']    = 'admin';
        $data['is_manual'] = true;

        Appointment::create($data);

        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully.');
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
        }

        return back()->with('success', 'Appointment updated.');
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
            return Service::active()->pluck('title')->values()->all();
        } catch (\Throwable) {
            return [];
        }
    }
}
