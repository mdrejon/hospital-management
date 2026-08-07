<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalTestBooking;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgentBookingsController extends Controller
{
    public function index(Request $request): Response
    {
        $agent = $request->user()->agentProfile;
        $tab = $request->input('tab', 'appointments'); // appointments or tests
        $search = $request->input('search');

        $appointments = $agent->appointments()
            ->with(['doctor', 'payments' => function ($q) {
                $q->latest();
            }])
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('preferred_doctor', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15, ['*'], 'apt_page')
            ->withQueryString();

        $testBookings = $agent->medicalTestBookings()
            ->with(['items.medicalTest', 'payments' => function ($q) {
                $q->latest();
            }])
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('booking_number', 'like', "%{$search}%")
                        ->orWhere('patient_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15, ['*'], 'test_page')
            ->withQueryString();

        $paymentSettings = PaymentService::getActiveGateways();

        return Inertia::render('Agent/Bookings', [
            'appointments'    => $appointments,
            'testBookings'    => $testBookings,
            'activeTab'       => $tab,
            'search'          => $search,
            'paymentSettings' => $paymentSettings,
        ]);
    }
}
