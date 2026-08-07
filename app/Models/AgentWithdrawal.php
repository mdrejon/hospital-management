<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'withdrawal_number',
        'amount',
        'payout_method',
        'account_number',
        'account_type',
        'bank_details',
        'status',
        'transaction_id',
        'admin_notes',
        'processed_by_user_id',
        'processed_at',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'bank_details' => 'array',
        'processed_at' => 'datetime',
    ];

    const STATUS_PENDING    = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_APPROVED   = 'approved';
    const STATUS_REJECTED   = 'rejected';

    public function agent(): BelongsTo
    {
        return $this->belongsTo(AgentProfile::class, 'agent_id');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by_user_id');
    }

    public static function generateNumber(): string
    {
        return 'WD-' . date('Ymd') . '-' . str_pad((static::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT);
    }
}
