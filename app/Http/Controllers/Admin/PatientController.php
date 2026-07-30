<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    /** Patient directory — one row per patient, with their appointment count and most recent visit. */
    public function index(): Response
    {
        $patients = Patient::withCount('appointments')
            ->withMax('appointments', 'appointment_date')
            ->orderByDesc('id')
            ->get()
            ->map(function (Patient $patient) {
                $patient->last_visit = $patient->appointments_max_appointment_date;
                return $patient;
            });

        return Inertia::render('Admin/Patients/Index', [
            'patients' => $patients,
        ]);
    }

    /** Full profile — patient details plus the complete history of every appointment they've ever booked. */
    public function show(Patient $patient): Response
    {
        $patient->load(['appointments' => fn ($q) => $q->with('doctor:id,name')->orderByDesc('appointment_date')->orderByDesc('id')]);

        return Inertia::render('Admin/Patients/Show', [
            'patient' => $patient,
        ]);
    }
}
