<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalTestBookingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_test_booking_id',
        'medical_test_id',
        'test_name',
        'test_code',
        'unit_price',
        'discount_amount',
        'agent_discount_amount',
        'final_price',
        'commission_rate',
        'commission_amount',
        'commission_base_price',
        'status',
        'report_file',
    ];

    protected $casts = [
        'unit_price'            => 'decimal:2',
        'discount_amount'       => 'decimal:2',
        'agent_discount_amount' => 'decimal:2',
        'final_price'           => 'decimal:2',
        'commission_rate'       => 'decimal:2',
        'commission_amount'     => 'decimal:2',
        'commission_base_price' => 'decimal:2',
    ];

    const STATUS_PENDING          = 'pending';
    const STATUS_SAMPLE_COLLECTED = 'sample_collected';
    const STATUS_TESTING          = 'testing';
    const STATUS_COMPLETED        = 'completed';
    const STATUS_CANCELLED        = 'cancelled';

    public function booking(): BelongsTo
    {
        return $this->belongsTo(MedicalTestBooking::class, 'medical_test_booking_id');
    }

    public function medicalTest(): BelongsTo
    {
        return $this->belongsTo(MedicalTest::class, 'medical_test_id');
    }
}
