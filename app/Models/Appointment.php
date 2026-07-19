<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'department', 'preferred_doctor', 'preferred_date',
        'message', 'status', 'source', 'is_manual', 'notes',
    ];

    protected $casts = [
        'is_manual' => 'boolean',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';
}
