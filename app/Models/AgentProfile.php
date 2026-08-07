<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_code',
        'phone',
        'nid_number',
        'nid_file',
        'address',
        'city',
        'commission_type',
        'doctor_commission_rate',
        'test_commission_rate',
        'wallet_balance',
        'total_earned_commission',
        'total_withdrawn_commission',
        'payout_method',
        'payout_account_number',
        'payout_account_type',
        'bank_details',
        'status',
        'approved_by',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'doctor_commission_rate'     => 'decimal:2',
        'test_commission_rate'       => 'decimal:2',
        'wallet_balance'             => 'decimal:2',
        'total_earned_commission'    => 'decimal:2',
        'total_withdrawn_commission' => 'decimal:2',
        'bank_details'               => 'array',
        'approved_at'                => 'datetime',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_ACTIVE    = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_REJECTED  = 'rejected';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'agent_id');
    }

    public function medicalTestBookings(): HasMany
    {
        return $this->hasMany(MedicalTestBooking::class, 'agent_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(AgentCommission::class, 'agent_id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(AgentWithdrawal::class, 'agent_id');
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(AgentWalletTransaction::class, 'agent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public static function generateCode(): string
    {
        $lastId = static::max('id') ?? 0;
        return 'AGT-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }
}
