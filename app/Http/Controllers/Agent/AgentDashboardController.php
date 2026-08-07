<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentProfile;
use App\Models\Appointment;
use App\Models\MedicalTestBooking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgentDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $agent = $user->agentProfile;

        if (!$agent) {
            // Auto-create profile if role is agent
            $agent = AgentProfile::create([
                'user_id'                => $user->id,
                'agent_code'             => AgentProfile::generateCode(),
                'phone'                  => $user->phone ?? '01700000000',
                'status'                 => AgentProfile::STATUS_ACTIVE,
                'doctor_commission_rate' => 10.00,
                'test_commission_rate'   => 15.00,
            ]);
        }

        $stats = [
            'wallet_balance'       => (float) $agent->wallet_balance,
            'total_earned'         => (float) $agent->total_earned_commission,
            'total_withdrawn'      => (float) $agent->total_withdrawn_commission,
            'total_appointments'   => $agent->appointments()->count(),
            'total_tests'          => $agent->medicalTestBookings()->count(),
            'pending_commissions'  => (float) $agent->commissions()->where('status', 'pending')->sum('amount'),
            'doctor_rate'          => (float) $agent->doctor_commission_rate,
            'test_rate'            => (float) $agent->test_commission_rate,
            'commission_type'      => $agent->commission_type,
        ];

        $recentAppointments = $agent->appointments()
            ->with(['doctor'])
            ->latest()
            ->take(5)
            ->get();

        $recentTests = $agent->medicalTestBookings()
            ->with(['items'])
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = $agent->walletTransactions()
            ->latest()
            ->take(6)
            ->get();

        return Inertia::render('Agent/Dashboard', [
            'agent'              => $agent,
            'stats'              => $stats,
            'recentAppointments' => $recentAppointments,
            'recentTests'        => $recentTests,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}
