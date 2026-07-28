<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorAvailability extends Model
{
    public const WEEKDAYS = [
        0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
        4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday',
    ];

    protected $fillable = [
        'doctor_id', 'weekday', 'start_time', 'end_time', 'slot_duration_minutes', 'is_active',
    ];

    protected $casts = [
        'weekday'                => 'integer',
        'slot_duration_minutes'  => 'integer',
        'is_active'               => 'boolean',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
