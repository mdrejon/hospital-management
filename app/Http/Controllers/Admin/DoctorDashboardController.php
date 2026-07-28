<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DoctorDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $doctor = $request->user()->doctor;

        if (!$doctor) {
            return Inertia::render('Admin/Doctor/Dashboard', [
                'unlinked' => true,
                'today' => [], 'upcoming' => [], 'completed' => [], 'pending' => [], 'followUp' => [],
                'stats' => ['today' => 0, 'upcoming' => 0, 'completed' => 0, 'pending' => 0, 'followUp' => 0],
            ]);
        }

        $today = today();

        $base = fn () => Appointment::where('doctor_id', $doctor->id);

        return Inertia::render('Admin/Doctor/Dashboard', [
            'unlinked' => false,
            'doctorName' => $doctor->name,
            'today'     => $base()->whereDate('appointment_date', $today)->orderBy('time_slot')->get(),
            'upcoming'  => $base()->whereDate('appointment_date', '>', $today)->whereIn('status', Appointment::ACTIVE_STATUSES)->orderBy('appointment_date')->orderBy('time_slot')->limit(20)->get(),
            'completed' => $base()->where('status', Appointment::STATUS_COMPLETED)->whereDate('appointment_date', $today)->orderBy('time_slot')->get(),
            'pending'   => $base()->where('status', Appointment::STATUS_PENDING)->orderBy('appointment_date')->orderBy('time_slot')->limit(20)->get(),
            'followUp'  => $base()->where('status', Appointment::STATUS_FOLLOW_UP_REQUIRED)->orderBy('appointment_date')->limit(20)->get(),
            'stats' => [
                'today'     => $base()->whereDate('appointment_date', $today)->count(),
                'upcoming'  => $base()->whereDate('appointment_date', '>', $today)->whereIn('status', Appointment::ACTIVE_STATUSES)->count(),
                'completed' => $base()->where('status', Appointment::STATUS_COMPLETED)->count(),
                'pending'   => $base()->where('status', Appointment::STATUS_PENDING)->count(),
                'followUp'  => $base()->where('status', Appointment::STATUS_FOLLOW_UP_REQUIRED)->count(),
            ],
        ]);
    }

    /** Doctor updates their own patient's status through the consultation flow. */
    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $doctor = $request->user()->doctor;
        if (!$doctor || $appointment->doctor_id !== $doctor->id) {
            abort(403);
        }

        $data = $request->validate([
            'status' => 'required|in:checked_in,in_consultation,completed,follow_up_required,no_show',
            'notes'  => 'nullable|string',
        ]);

        $appointment->update($data);

        return back()->with('success', 'Patient status updated.');
    }
}
