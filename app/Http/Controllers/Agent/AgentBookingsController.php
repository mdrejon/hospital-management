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
            ->paginate(15)
            ->withQueryString();

        $paymentSettings = PaymentService::getActiveGateways();

        return Inertia::render('Agent/Bookings', [
            'appointments'    => $appointments,
            'search'          => $search,
            'paymentSettings' => $paymentSettings,
        ]);
    }

    public function show(Request $request, Appointment $appointment): Response
    {
        $agent = $request->user()->agentProfile;
        
        // Ensure the appointment belongs to this agent
        if ($appointment->agent_id !== $agent->id) {
            abort(403);
        }

        $appointment->load([
            'doctor.specialization',
            'patient',
            'payments',
        ]);

        return Inertia::render('Agent/Appointments/Show', [
            'booking' => $appointment,
        ]);
    }

    public function invoice(Request $request, Appointment $appointment): Response
    {
        $agent = $request->user()->agentProfile;
        
        // Ensure the appointment belongs to this agent
        if ($appointment->agent_id !== $agent->id) {
            abort(403);
        }

        $appointment->load([
            'doctor.specialization',
            'agent.user',
            'patient',
            'payments',
        ]);

        return Inertia::render('Agent/Appointments/Invoice', [
            'booking' => $appointment,
        ]);
    }

    public function tests(Request $request): Response
    {
        $agent = $request->user()->agentProfile;
        $search = $request->input('search');

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
            ->paginate(15)
            ->withQueryString();

        $paymentSettings = PaymentService::getActiveGateways();

        return Inertia::render('Agent/TestBookings', [
            'testBookings'    => $testBookings,
            'search'          => $search,
            'paymentSettings' => $paymentSettings,
        ]);
    }
    public function testShow(Request $request, MedicalTestBooking $testBooking): Response
    {
        $agent = $request->user()->agentProfile;
        
        // Ensure the booking belongs to this agent
        if ($testBooking->agent_id !== $agent->id) {
            abort(403);
        }

        $testBooking->load([
            'items.medicalTest',
            'agent.user',
            'payments',
        ]);

        return Inertia::render('Agent/MedicalTests/Show', [
            'booking' => $testBooking,
        ]);
    }

    public function testInvoice(Request $request, MedicalTestBooking $testBooking): Response
    {
        $agent = $request->user()->agentProfile;
        
        // Ensure the booking belongs to this agent
        if ($testBooking->agent_id !== $agent->id) {
            abort(403);
        }

        $testBooking->load([
            'items.medicalTest',
            'agent.user',
            'payments',
        ]);

        return Inertia::render('Agent/MedicalTests/Invoice', [
            'booking' => $testBooking,
        ]);
    }
}
