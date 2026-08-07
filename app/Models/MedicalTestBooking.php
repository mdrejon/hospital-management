<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalTestBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'patient_id',
        'doctor_id',
        'booked_by_user_id',
        'agent_id',
        'patient_name',
        'phone',
        'email',
        'gender',
        'date_of_birth',
        'address',
        'booking_date',
        'preferred_date',
        'subtotal_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'payment_status',
        'payment_method',
        'agent_commission_amount',
        'agent_commission_status',
        'status',
        'report_delivery_date',
        'notes',
    ];

    protected $casts = [
        'booking_date'            => 'date',
        'preferred_date'          => 'date',
        'date_of_birth'           => 'date',
        'report_delivery_date'    => 'date',
        'subtotal_amount'         => 'decimal:2',
        'discount_amount'         => 'decimal:2',
        'total_amount'            => 'decimal:2',
        'paid_amount'             => 'decimal:2',
        'due_amount'              => 'decimal:2',
        'agent_commission_amount' => 'decimal:2',
    ];

    const STATUS_PENDING          = 'pending';
    const STATUS_SAMPLE_COLLECTED = 'sample_collected';
    const STATUS_PROCESSING       = 'processing';
    const STATUS_COMPLETED        = 'completed';
    const STATUS_CANCELLED        = 'cancelled';

    const PAYMENT_UNPAID  = 'unpaid';
    const PAYMENT_PARTIAL = 'partial';
    const PAYMENT_PAID    = 'paid';

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

    public function items(): HasMany
    {
        return $this->hasMany(MedicalTestBookingItem::class, 'medical_test_booking_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(AgentCommission::class, 'source_id')->where('source_type', 'medical_test');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function latestPayment()
    {
        return $this->morphOne(Payment::class, 'payable')->latestOfMany();
    }

    public static function generateNumber(): string
    {
        return 'TB-' . date('Ymd') . '-' . str_pad((static::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT);
    }

    public static function generateBookingNumber(): string
    {
        return static::generateNumber();
    }
}
