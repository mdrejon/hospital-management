<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Services\CommissionService;
use App\Services\PaymentService;
use App\Services\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgentDoctorBookingController extends Controller
{
    public function create(Request $request): Response
    {
        $agent = $request->user()->agentProfile;

        $doctors = Doctor::with(['specialization', 'availabilities', 'chambers'])
            ->active()
            ->get();

        $specializations = \App\Models\DoctorSpecialization::active()->get(['id', 'name']);

        $paymentSettings = PaymentService::getActiveGateways();

        return Inertia::render('Agent/BookDoctor', [
            'doctors'         => $doctors,
            'specializations' => $specializations,
            'agent'           => $agent,
            'paymentSettings' => $paymentSettings,
        ]);
    }

    public function store(Request $request)
    {
        $agent = $request->user()->agentProfile;

        $validated = $request->validate([
            'doctor_id'        => ['required', 'exists:doctors,id'],
            'name'             => ['required', 'string', 'max:255'],
            'phone'            => ['required', 'string', 'max:30'],
            'email'            => ['nullable', 'email', 'max:255'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot'        => ['nullable', 'string', 'max:50'],
            'symptoms'         => ['nullable', 'string'],
            'message'          => ['nullable', 'string'],
            'gender'           => ['required', 'in:male,female,other'],
            'marital_status'   => ['required', 'string'],
            'address'          => ['required', 'string'],
            'date_of_birth'    => ['nullable', 'date'],
            'payment_type'     => ['required', 'in:without_pay,online'],
            'payment_gateway'  => ['nullable', 'required_if:payment_type,online', 'in:sslcommerz,bkash'],
        ]);

        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $fee = (float) ($doctor->consultation_fee ?? 0);

        // Find or create patient
        $patient = Patient::firstOrCreate(
            ['phone' => $validated['phone']],
            [
                'name'           => $validated['name'],
                'email'          => $validated['email'] ?? null,
                'gender'         => $validated['gender'],
                'marital_status' => $validated['marital_status'],
                'date_of_birth'  => $validated['date_of_birth'] ?? null,
                'address'        => $validated['address'],
            ]
        );

        $serialNumber = (Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->count()) + 1;

        $appointment = Appointment::create([
            'patient_id'        => $patient->id,
            'doctor_id'         => $doctor->id,
            'booked_by_user_id' => $request->user()->id,
            'agent_id'          => $agent->id,
            'name'              => $validated['name'],
            'email'             => $validated['email'] ?? "patient_{$patient->id}@hospital.com",
            'phone'             => $validated['phone'],
            'department'        => $doctor->specialization?->name ?? 'General',
            'preferred_doctor'  => $doctor->name,
            'appointment_date'  => $validated['appointment_date'],
            'time_slot'         => $validated['time_slot'] ?? '10:00 AM',
            'serial_number'     => $serialNumber,
            'fee'               => $fee,
            'payment_status'    => 'unpaid',
            'paid_amount'       => 0,
            'payment_method'    => $validated['payment_type'] === 'online' ? $validated['payment_gateway'] : 'without_pay',
            'symptoms'          => $validated['symptoms'] ?? null,
            'message'           => $validated['message'] ?? null,
            'status'            => Appointment::STATUS_PENDING,
            'source'            => 'agent_portal',
            'is_manual'         => false,
        ]);

        // Calculate and create pending commission
        CommissionService::handleAppointmentCommission($appointment);

        // Send SMS to Patient
        try {
            SmsService::sendAppointmentBookedAlert($appointment);
        } catch (\Throwable $e) {}

        // If online payment is selected and fee > 0
        if ($validated['payment_type'] === 'online' && $fee > 0) {
            $payment = PaymentService::createPayment(
                $appointment,
                $validated['payment_gateway'],
                $fee
            );

            $result = PaymentService::processPayment(
                $payment,
                [
                    'name'    => $appointment->name,
                    'phone'   => $appointment->phone,
                    'email'   => $appointment->email,
                    'address' => 'Dhaka, Bangladesh',
                ],
                route('agent.bookings.index')
            );

            if (!empty($result['redirect_url'])) {
                return Inertia::location($result['redirect_url']);
            }
        }

        return redirect()->route('agent.bookings.index')
            ->with('success', "Doctor appointment booked successfully for {$appointment->name}! Serial #{$serialNumber}.");
    }
}
