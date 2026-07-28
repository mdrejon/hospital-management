<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Inquiry;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if ($user->isDoctor()) {
            return redirect()->route('admin.doctor-dashboard.index');
        }

        if ($user->isOperator()) {
            return redirect()->route('admin.operator.dashboard');
        }

        $today = today();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'todayAppointments'   => Appointment::whereDate('appointment_date', $today)->count(),
                'pendingAppointments' => Appointment::where('status', Appointment::STATUS_PENDING)->count(),
                'totalAppointments'   => Appointment::count(),
                'totalDoctors'        => Doctor::where('is_active', true)->count(),
                'totalPatients'       => Patient::count(),
                'newInquiries'        => Inquiry::where('status', Inquiry::STATUS_NEW)->count(),
                'totalUsers'          => User::count(),
            ],
            'recentAppointments' => Appointment::with('doctor:id,name')
                ->latest()
                ->take(6)
                ->get(['id', 'doctor_id', 'name', 'phone', 'appointment_date', 'time_slot', 'status', 'created_at']),
            'recentInquiries' => Inquiry::latest()
                ->take(5)
                ->get(['id', 'type', 'name', 'subject', 'status', 'created_at']),
            'statusBreakdown' => collect(Appointment::STATUSES)
                ->map(fn ($status) => [
                    'status' => $status,
                    'count'  => Appointment::where('status', $status)->count(),
                ])
                ->all(),
            'weeklyTrend' => collect(range(6, 0))
                ->map(function ($daysAgo) {
                    $date = today()->subDays($daysAgo);
                    return [
                        'date'  => $date->toDateString(),
                        'label' => $date->format('D'),
                        'count' => Appointment::whereDate('appointment_date', $date)->count(),
                    ];
                })
                ->values()
                ->all(),
        ]);
    }
}
