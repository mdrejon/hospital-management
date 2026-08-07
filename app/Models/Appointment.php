<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'booked_by_user_id', 'agent_id',
        'name', 'email', 'phone', 'department', 'appointment_type',
        'preferred_doctor', 'preferred_date', 'appointment_date', 'time_slot',
        'serial_number', 'fee', 'payment_status', 'paid_amount', 'payment_method',
        'agent_commission_amount', 'agent_commission_status',
        'message', 'symptoms', 'document', 'documents', 'prescription_file',
        'status', 'source', 'is_manual', 'notes',
    ];

    protected $casts = [
        'is_manual'               => 'boolean',
        'appointment_date'        => 'date',
        'fee'                     => 'decimal:2',
        'paid_amount'             => 'decimal:2',
        'agent_commission_amount' => 'decimal:2',
        'serial_number'           => 'integer',
        'documents'               => 'array',
    ];

    const STATUS_PENDING            = 'pending';
    const STATUS_CONFIRMED          = 'confirmed';
    const STATUS_CHECKED_IN         = 'checked_in';
    const STATUS_IN_CONSULTATION    = 'in_consultation';
    const STATUS_COMPLETED          = 'completed';
    const STATUS_FOLLOW_UP_REQUIRED = 'follow_up_required';
    const STATUS_CANCELLED          = 'cancelled';
    const STATUS_NO_SHOW            = 'no_show';

    const STATUSES = [
        self::STATUS_PENDING, self::STATUS_CONFIRMED, self::STATUS_CHECKED_IN,
        self::STATUS_IN_CONSULTATION, self::STATUS_COMPLETED, self::STATUS_FOLLOW_UP_REQUIRED,
        self::STATUS_CANCELLED, self::STATUS_NO_SHOW,
    ];

    /** Statuses that still occupy/count toward a doctor's daily slot capacity. */
    const ACTIVE_STATUSES = [
        self::STATUS_PENDING, self::STATUS_CONFIRMED, self::STATUS_CHECKED_IN,
        self::STATUS_IN_CONSULTATION, self::STATUS_COMPLETED, self::STATUS_FOLLOW_UP_REQUIRED,
    ];

    const TYPE_OPD       = 'opd';
    const TYPE_FOLLOW_UP = 'follow_up';

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bookedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'booked_by_user_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(AgentProfile::class, 'agent_id');
    }

    public function commissions()
    {
        return $this->hasMany(AgentCommission::class, 'source_id')->where('source_type', 'appointment');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function latestPayment()
    {
        return $this->morphOne(Payment::class, 'payable')->latestOfMany();
    }

    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    public function scopeForDoctor($query, int $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }
}
