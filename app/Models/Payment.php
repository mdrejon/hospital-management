<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payable_type',
        'payable_id',
        'gateway',
        'transaction_id',
        'val_id',
        'payment_method',
        'currency',
        'amount',
        'status',
        'payment_details',
        'ipn_response',
        'paid_at',
    ];

    protected $casts = [
        'amount'          => 'decimal:2',
        'payment_details' => 'array',
        'ipn_response'    => 'array',
        'paid_at'         => 'datetime',
    ];

    const STATUS_PENDING    = 'pending';
    const STATUS_SUCCESSFUL = 'successful';
    const STATUS_FAILED     = 'failed';
    const STATUS_CANCELLED  = 'cancelled';

    const GATEWAY_SSLCOMMERZ = 'sslcommerz';
    const GATEWAY_BKASH      = 'bkash';

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_SUCCESSFUL;
    }
}
