<?php

namespace App\Services;

use App\Models\AgentCommission;
use App\Models\AgentProfile;
use App\Models\AgentWalletTransaction;
use App\Models\AgentWithdrawal;
use App\Models\Appointment;
use App\Models\GlobalSetting;
use App\Models\MedicalTest;
use App\Models\MedicalTestBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommissionService
{
    /**
     * Calculate doctor appointment commission for an agent.
     */
    public static function calculateDoctorCommission(AgentProfile $agent, float $fee): array
    {
        $rate = $agent->doctor_commission_rate ?? (float) GlobalSetting::get('agent_default_doctor_commission_rate', 10.00);
        $type = $agent->commission_type ?? 'percentage';

        if ($type === 'percentage') {
            $amount = round(($fee * $rate) / 100, 2);
        } else {
            $amount = round($rate, 2);
        }

        return [
            'rate'   => $rate,
            'type'   => $type,
            'amount' => max(0, $amount),
        ];
    }

    /**
     * Resolve commission rate for a specific test.
     * Priority: test-specific rate > agent global rate > system default.
     */
    public static function resolveTestCommissionRate(MedicalTest $test, AgentProfile $agent): float
    {
        // If test has its own rate (non-null), use it
        if ($test->commission_rate !== null) {
            return (float) $test->commission_rate;
        }
        // Otherwise fall back to agent's global test rate
        return (float) ($agent->test_commission_rate ?? GlobalSetting::get('agent_default_test_commission_rate', 15.00));
    }

    /**
     * Calculate medical test booking commission for an agent.
     */
    public static function calculateTestCommission(AgentProfile $agent, float $totalAmount): array
    {
        $rate = $agent->test_commission_rate ?? (float) GlobalSetting::get('agent_default_test_commission_rate', 15.00);
        $type = $agent->commission_type ?? 'percentage';

        if ($type === 'percentage') {
            $amount = round(($totalAmount * $rate) / 100, 2);
        } else {
            $amount = round($rate, 2);
        }

        return [
            'rate'   => $rate,
            'type'   => $type,
            'amount' => max(0, $amount),
        ];
    }

    /**
     * Handle Doctor Appointment commission creation.
     */
    public static function handleAppointmentCommission(Appointment $appointment): ?AgentCommission
    {
        if (!$appointment->agent_id || $appointment->fee <= 0) {
            return null;
        }

        $agent = AgentProfile::find($appointment->agent_id);
        if (!$agent || $agent->status !== AgentProfile::STATUS_ACTIVE) {
            return null;
        }

        $calc = self::calculateDoctorCommission($agent, (float) $appointment->fee);
        $amount = $calc['amount'];
        if ($amount <= 0) {
            return null;
        }

        $isPaid = $appointment->payment_status === 'paid' || $appointment->status === Appointment::STATUS_COMPLETED;
        $status = $isPaid ? AgentCommission::STATUS_CREDITED : AgentCommission::STATUS_PENDING;

        return DB::transaction(function () use ($appointment, $agent, $calc, $amount, $status, $isPaid) {
            $appointment->agent_commission_amount = $amount;
            $appointment->agent_commission_status = $status;
            $appointment->saveQuietly();

            $commission = AgentCommission::updateOrCreate(
                [
                    'agent_id'    => $agent->id,
                    'source_type' => 'appointment',
                    'source_id'   => $appointment->id,
                ],
                [
                    'booking_reference' => 'APT #' . $appointment->id . ($appointment->serial_number ? " (Serial #{$appointment->serial_number})" : ''),
                    'amount'            => $amount,
                    'commission_rate'   => $calc['rate'],
                    'status'            => $status,
                    'credited_at'       => $isPaid ? now() : null,
                    'notes'             => "Commission for Doctor appointment with {$appointment->doctor?->name}",
                ]
            );

            if ($isPaid) {
                self::creditWallet(
                    $agent,
                    $amount,
                    $commission,
                    "Doctor appointment commission: APT #{$appointment->id}"
                );
            }

            return $commission;
        });
    }

    /**
     * Handle Medical Test booking commission creation.
     */
    public static function handleMedicalTestCommission(MedicalTestBooking $booking, float $agentDiscountTotal = 0.0): ?AgentCommission
    {
        if (!$booking->agent_id || $booking->total_amount <= 0) {
            return null;
        }

        $agent = AgentProfile::find($booking->agent_id);
        if (!$agent || $agent->status !== AgentProfile::STATUS_ACTIVE) {
            return null;
        }

        $items = $booking->items()->with('medicalTest')->get();
        if ($items->isEmpty()) {
            return null;
        }

        $totalCommission = 0.0;
        $effectiveTotal = (float) $booking->total_amount; // already includes agent discount

        // Distribute agent discount proportionally across items
        $subtotalAfterCatalogDiscount = $items->sum(fn($item) => (float)$item->final_price);

        foreach ($items as $item) {
            $test = $item->medicalTest;
            $rate = self::resolveTestCommissionRate($test, $agent);

            // Proportional agent discount for this item
            $proportion = $subtotalAfterCatalogDiscount > 0
                ? ((float)$item->final_price / $subtotalAfterCatalogDiscount)
                : (1 / max(1, $items->count()));

            $itemAgentDiscount = round($agentDiscountTotal * $proportion, 2);
            $commissionBase   = max(0, (float)$item->final_price - $itemAgentDiscount);
            $itemCommission   = round($commissionBase * $rate / 100, 2);
            $totalCommission += $itemCommission;

            // Update the booking item with commission breakdown
            $item->update([
                'agent_discount_amount'  => $itemAgentDiscount,
                'commission_rate'        => $rate,
                'commission_base_price'  => $commissionBase,
                'commission_amount'      => $itemCommission,
            ]);
        }

        if ($totalCommission <= 0) {
            return null;
        }

        $isPaid = $booking->payment_status === MedicalTestBooking::PAYMENT_PAID || $booking->status === MedicalTestBooking::STATUS_COMPLETED;
        $status = $isPaid ? AgentCommission::STATUS_CREDITED : AgentCommission::STATUS_PENDING;

        return DB::transaction(function () use ($booking, $agent, $totalCommission, $status, $isPaid) {
            $booking->agent_commission_amount = $totalCommission;
            $booking->agent_commission_status = $status;
            $booking->saveQuietly();

            $commission = AgentCommission::updateOrCreate(
                [
                    'agent_id'    => $agent->id,
                    'source_type' => 'medical_test',
                    'source_id'   => $booking->id,
                ],
                [
                    'booking_reference' => $booking->booking_number,
                    'amount'            => $totalCommission,
                    'commission_rate'   => 0,
                    'status'            => $status,
                    'credited_at'       => $isPaid ? now() : null,
                    'notes'             => "Commission for Medical Test Booking {$booking->booking_number}",
                ]
            );

            if ($isPaid) {
                self::creditWallet(
                    $agent,
                    $totalCommission,
                    $commission,
                    "Medical test booking commission: {$booking->booking_number}"
                );
            }

            return $commission;
        });
    }

    /**
     * Credit commission to agent wallet upon payment/completion.
     */
    public static function creditWallet(AgentProfile $agent, float $amount, AgentCommission $commission, string $description): void
    {
        // Avoid double credit
        $alreadyCredited = AgentWalletTransaction::where('agent_id', $agent->id)
            ->where('reference_type', AgentCommission::class)
            ->where('reference_id', $commission->id)
            ->exists();

        if ($alreadyCredited) {
            return;
        }

        $balanceBefore = (float) $agent->wallet_balance;
        $balanceAfter  = round($balanceBefore + $amount, 2);

        $agent->wallet_balance = $balanceAfter;
        $agent->total_earned_commission = round((float) $agent->total_earned_commission + $amount, 2);
        $agent->saveQuietly();

        AgentWalletTransaction::create([
            'agent_id'       => $agent->id,
            'type'           => AgentWalletTransaction::TYPE_CREDIT_COMMISSION,
            'amount'         => $amount,
            'balance_before' => $balanceBefore,
            'balance_after'  => $balanceAfter,
            'reference_type' => AgentCommission::class,
            'reference_id'   => $commission->id,
            'description'    => $description,
        ]);

        $commission->status = AgentCommission::STATUS_CREDITED;
        $commission->credited_at = now();
        $commission->saveQuietly();

        // Send SMS to Agent
        try {
            SmsService::sendCommissionAlert($agent, $amount, $description);
        } catch (\Throwable $e) {
            Log::warning('Failed sending commission SMS: ' . $e->getMessage());
        }
    }

    /**
     * Process Agent Cash Out Request (Deduct from balance upon request submission).
     */
    public static function requestWithdrawal(AgentProfile $agent, float $amount, array $payoutData): AgentWithdrawal
    {
        return DB::transaction(function () use ($agent, $amount, $payoutData) {
            $balanceBefore = (float) $agent->wallet_balance;
            $balanceAfter  = round($balanceBefore - $amount, 2);

            $agent->wallet_balance = $balanceAfter;
            $agent->saveQuietly();

            $withdrawal = AgentWithdrawal::create([
                'agent_id'          => $agent->id,
                'withdrawal_number' => AgentWithdrawal::generateNumber(),
                'amount'            => $amount,
                'payout_method'     => $payoutData['payout_method'] ?? 'bkash',
                'account_number'    => $payoutData['account_number'],
                'account_type'      => $payoutData['account_type'] ?? 'personal',
                'bank_details'      => $payoutData['bank_details'] ?? null,
                'status'            => AgentWithdrawal::STATUS_PENDING,
            ]);

            AgentWalletTransaction::create([
                'agent_id'       => $agent->id,
                'type'           => AgentWalletTransaction::TYPE_DEBIT_WITHDRAWAL,
                'amount'         => $amount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $balanceAfter,
                'reference_type' => AgentWithdrawal::class,
                'reference_id'   => $withdrawal->id,
                'description'    => "Cash out request via {$withdrawal->payout_method} ({$withdrawal->account_number})",
            ]);

            return $withdrawal;
        });
    }

    /**
     * Admin Approves Cash Out Request.
     */
    public static function approveWithdrawal(AgentWithdrawal $withdrawal, string $transactionId = null, string $notes = null, int $processedByUserId = null): void
    {
        DB::transaction(function () use ($withdrawal, $transactionId, $notes, $processedByUserId) {
            $agent = $withdrawal->agent;

            $withdrawal->status = AgentWithdrawal::STATUS_APPROVED;
            $withdrawal->transaction_id = $transactionId;
            $withdrawal->admin_notes = $notes;
            $withdrawal->processed_by_user_id = $processedByUserId;
            $withdrawal->processed_at = now();
            $withdrawal->saveQuietly();

            $agent->total_withdrawn_commission = round((float) $agent->total_withdrawn_commission + (float) $withdrawal->amount, 2);
            $agent->saveQuietly();

            try {
                SmsService::sendWithdrawalStatusAlert($withdrawal);
            } catch (\Throwable $e) {
                Log::warning('Failed sending withdrawal approval SMS: ' . $e->getMessage());
            }
        });
    }

    /**
     * Admin Rejects Cash Out Request (Refund balance back to agent).
     */
    public static function rejectWithdrawal(AgentWithdrawal $withdrawal, string $notes, int $processedByUserId = null): void
    {
        DB::transaction(function () use ($withdrawal, $notes, $processedByUserId) {
            $agent = $withdrawal->agent;

            $withdrawal->status = AgentWithdrawal::STATUS_REJECTED;
            $withdrawal->admin_notes = $notes;
            $withdrawal->processed_by_user_id = $processedByUserId;
            $withdrawal->processed_at = now();
            $withdrawal->saveQuietly();

            // Refund balance
            $balanceBefore = (float) $agent->wallet_balance;
            $balanceAfter  = round($balanceBefore + (float) $withdrawal->amount, 2);

            $agent->wallet_balance = $balanceAfter;
            $agent->saveQuietly();

            AgentWalletTransaction::create([
                'agent_id'       => $agent->id,
                'type'           => AgentWalletTransaction::TYPE_WITHDRAWAL_REFUND,
                'amount'         => (float) $withdrawal->amount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $balanceAfter,
                'reference_type' => AgentWithdrawal::class,
                'reference_id'   => $withdrawal->id,
                'description'    => "Refund for rejected cash out request #{$withdrawal->withdrawal_number}",
            ]);

            try {
                SmsService::sendWithdrawalStatusAlert($withdrawal);
            } catch (\Throwable $e) {
                Log::warning('Failed sending withdrawal reject SMS: ' . $e->getMessage());
            }
        });
    }
}
