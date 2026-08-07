<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'source_type',
        'source_id',
        'booking_reference',
        'amount',
        'commission_rate',
        'status',
        'credited_at',
        'notes',
    ];

    protected $casts = [
        'amount'          => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'credited_at'     => 'datetime',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_CREDITED  = 'credited';
    const STATUS_CANCELLED = 'cancelled';

    public function agent(): BelongsTo
    {
        return $this->belongsTo(AgentProfile::class, 'agent_id');
    }

    public function source()
    {
        if ($this->source_type === 'appointment') {
            return $this->belongsTo(Appointment::class, 'source_id');
        }
        return $this->belongsTo(MedicalTestBooking::class, 'source_id');
    }
}
