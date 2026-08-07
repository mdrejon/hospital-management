<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentWalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference_type',
        'reference_id',
        'description',
    ];

    protected $casts = [
        'amount'         => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after'  => 'decimal:2',
    ];

    const TYPE_CREDIT_COMMISSION  = 'credit_commission';
    const TYPE_DEBIT_WITHDRAWAL   = 'debit_withdrawal';
    const TYPE_ADJUSTMENT_CREDIT  = 'adjustment_credit';
    const TYPE_ADJUSTMENT_DEBIT   = 'adjustment_debit';
    const TYPE_WITHDRAWAL_REFUND  = 'withdrawal_refund';

    public function agent(): BelongsTo
    {
        return $this->belongsTo(AgentProfile::class, 'agent_id');
    }
}
