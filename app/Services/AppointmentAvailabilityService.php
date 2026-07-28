<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

/**
 * Single source of truth for online booking availability. Only the doctor's
 * own-hospital weekly schedule (DoctorAvailability) and leave days
 * (DoctorLeave) determine bookable dates/slots — informational DoctorChamber
 * rows (including chambers outside our hospital) are never consulted here.
 */
class AppointmentAvailabilityService
{
    /** How many days ahead patients may book. */
    public const BOOKING_WINDOW_DAYS = 30;

    public function isDateBookable(Doctor $doctor, Carbon $date): bool
    {
        if ($date->isPast() && !$date->isToday()) {
            return false;
        }

        if ($this->isOnLeave($doctor, $date)) {
            return false;
        }

        $availability = $this->availabilityFor($doctor, $date);
        if (!$availability) {
            return false;
        }

        return count($this->availableSlots($doctor, $date)) > 0;
    }

    public function isOnLeave(Doctor $doctor, Carbon $date): bool
    {
        return $doctor->leaves()->whereDate('date', $date->toDateString())->exists();
    }

    public function availabilityFor(Doctor $doctor, Carbon $date)
    {
        return $doctor->availabilities()
            ->where('weekday', $date->dayOfWeek)
            ->where('is_active', true)
            ->first();
    }

    /** All slot start times (e.g. "09:00 AM") for the doctor's weekday window, regardless of booking status. */
    public function allSlots(Doctor $doctor, Carbon $date): array
    {
        $availability = $this->availabilityFor($doctor, $date);
        if (!$availability) {
            return [];
        }

        $start = Carbon::parse($date->toDateString() . ' ' . $availability->start_time);
        $end   = Carbon::parse($date->toDateString() . ' ' . $availability->end_time);
        $step  = max(1, (int) $availability->slot_duration_minutes);

        $slots = [];
        foreach (CarbonPeriod::create($start, "{$step} minutes", $end->copy()->subMinute()) as $slot) {
            $slots[] = $slot->format('h:i A');
        }

        return $slots;
    }

    /** Slots already taken by an active (non-cancelled/no-show) appointment for this doctor+date. */
    public function bookedSlots(Doctor $doctor, Carbon $date): array
    {
        return Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date->toDateString())
            ->whereIn('status', Appointment::ACTIVE_STATUSES)
            ->pluck('time_slot')
            ->filter()
            ->values()
            ->all();
    }

    public function availableSlots(Doctor $doctor, Carbon $date): array
    {
        if ($date->isPast() && !$date->isToday()) {
            return [];
        }

        if ($this->isOnLeave($doctor, $date)) {
            return [];
        }

        $all    = $this->allSlots($doctor, $date);
        $booked = $this->bookedSlots($doctor, $date);

        $slots = array_values(array_diff($all, $booked));

        // If today, drop slots already in the past.
        if ($date->isToday()) {
            $now = now();
            $slots = array_values(array_filter($slots, function ($slot) use ($date, $now) {
                return Carbon::parse($date->toDateString() . ' ' . $slot)->greaterThan($now);
            }));
        }

        return $slots;
    }

    public function isSlotAvailable(Doctor $doctor, Carbon $date, string $slot): bool
    {
        return in_array($slot, $this->availableSlots($doctor, $date), true);
    }

    /** Next serial number for a doctor's active appointments on a given date. */
    public function nextSerialNumber(Doctor $doctor, Carbon $date): int
    {
        $max = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $date->toDateString())
            ->whereIn('status', Appointment::ACTIVE_STATUSES)
            ->max('serial_number');

        return ((int) $max) + 1;
    }

    /** Dates (within the booking window) that are fully booked or on leave — for disabling in the date picker. */
    public function unavailableDates(Doctor $doctor): array
    {
        $dates = [];
        $cursor = today();
        $end    = today()->addDays(self::BOOKING_WINDOW_DAYS);

        while ($cursor->lte($end)) {
            if (!$this->isDateBookable($doctor, $cursor->copy())) {
                $dates[] = $cursor->toDateString();
            }
            $cursor->addDay();
        }

        return $dates;
    }
}
