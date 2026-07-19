<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\WebsiteSettings\AppointmentSettingController;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppointmentController extends Controller
{
    public function index(): Response
    {
        $appointments = Appointment::orderByDesc('id')->get();

        $stats = [
            'total'     => $appointments->count(),
            'pending'   => $appointments->where('status', 'pending')->count(),
            'confirmed' => $appointments->where('status', 'confirmed')->count(),
            'cancelled' => $appointments->where('status', 'cancelled')->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
        ];

        return Inertia::render('Admin/Appointments/Index', [
            'appointments' => $appointments,
            'stats'        => $stats,
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
            'status'           => 'nullable|in:pending,confirmed,cancelled,completed',
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
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes'  => 'nullable|string',
        ]);

        $appointment->update($data);

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
