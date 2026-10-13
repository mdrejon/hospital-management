<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentCommission;
use App\Models\AgentProfile;
use App\Models\AgentWithdrawal;
use App\Models\GlobalSetting;
use App\Models\MedicalTestBooking;
use App\Models\MedicalTestBookingItem;
use App\Services\CommissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgentWalletController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $agent = $user->agentProfile;

        if (!$agent) {
            $agent = AgentProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'agent_code'                 => AgentProfile::generateCode(),
                    'phone'                      => $user->phone ?? '01700000000',
                    'commission_type'            => 'percentage',
                    'doctor_commission_rate'     => 10.00,
                    'test_commission_rate'       => 15.00,
                    'payout_method'              => 'bkash',
                    'payout_account_type'        => 'personal',
                    'status'                     => AgentProfile::STATUS_ACTIVE,
                ]
            );
        }

        $tab = $request->input('tab', 'commissions'); // commissions, withdrawals, ledger

        // 1. Commissions Breakdown
        $commissions = $agent->commissions()
            ->latest()
            ->paginate(15, ['*'], 'com_page')
            ->withQueryString();

        $commissions->getCollection()->transform(function ($com) use ($agent) {
            if ($com->source_type === 'medical_test') {
                $booking = MedicalTestBooking::find($com->source_id);
                $items = MedicalTestBookingItem::where('medical_test_booking_id', $com->source_id)
                    ->get([
                        'test_name', 'test_code', 'unit_price', 'discount_amount', 'final_price',
                        'agent_discount_amount', 'gross_commission_amount', 'commission_rate',
                        'commission_base_price', 'commission_amount'
                    ]);

                $totalGross = 0.0;
                $totalDisc = 0.0;
                $totalBase = 0.0;
                foreach ($items as $item) {
                    $base = (float) ($item->commission_base_price ?: $item->unit_price);
                    if ((float) $item->gross_commission_amount <= 0 && (float) $item->commission_rate > 0) {
                        $item->gross_commission_amount = round($base * (float) $item->commission_rate / 100, 2);
                    }
                    $disc = (float) $item->agent_discount_amount;
                    $item->agent_discount_rate = ($base > 0 && $disc > 0) ? round(($disc / $base) * 100, 2) : 0.00;
                    $totalGross += (float) $item->gross_commission_amount;
                    $totalDisc += $disc;
                    $totalBase += $base;
                }

                if ((float) $com->commission_rate <= 0 && $totalBase > 0) {
                    $com->commission_rate = round(($totalGross / $totalBase) * 100, 2);
                } elseif ((float) $com->commission_rate <= 0) {
                    $com->commission_rate = (float) $agent->test_commission_rate;
                }

                $grossAmt = 0.0;
                if ($booking && (float) $booking->agent_gross_commission_amount > 0) {
                    $grossAmt = (float) $booking->agent_gross_commission_amount;
                } elseif ($totalGross > 0) {
                    $grossAmt = $totalGross;
                } else {
                    $grossAmt = (float) $com->amount;
                }

                $discAmt = 0.0;
                if ($booking && (float) $booking->agent_discount_amount > 0) {
                    $discAmt = (float) $booking->agent_discount_amount;
                } elseif ($totalDisc > 0) {
                    $discAmt = $totalDisc;
                }

                $discRate = 0.0;
                if ($booking && (float) $booking->agent_discount_value > 0) {
                    $discRate = (float) $booking->agent_discount_value;
                } elseif ($totalBase > 0 && $discAmt > 0) {
                    $discRate = round(($discAmt / $totalBase) * 100, 2);
                }

                $com->gross_commission_amount = $grossAmt;
                $com->agent_discount_amount = $discAmt;
                $com->agent_discount_rate = $discRate;
                $com->net_commission_amount = (float) $com->amount;
                $com->booking_items = $items;
            } elseif ($com->source_type === 'appointment') {
                if ((float) $com->commission_rate <= 0) {
                    $com->commission_rate = (float) $agent->doctor_commission_rate;
                }
                $com->gross_commission_amount = (float) $com->amount;
                $com->agent_discount_amount = 0.0;
                $com->agent_discount_rate = 0.0;
                $com->net_commission_amount = (float) $com->amount;
            }
            return $com;
        });

        // 2. Cash Out Requests
        $withdrawals = $agent->withdrawals()
            ->latest()
            ->paginate(10, ['*'], 'wd_page')
            ->withQueryString();

        // 3. Complete Wallet Transaction Ledger
        $transactions = $agent->walletTransactions()
            ->latest()
            ->paginate(15, ['*'], 'tx_page')
            ->withQueryString();

        $minWithdrawalAmount = (float) GlobalSetting::get('agent_min_withdrawal_amount', 100.00);

        $pendingWithdrawalsSum = (float) $agent->withdrawals()
            ->whereIn('status', [AgentWithdrawal::STATUS_PENDING, AgentWithdrawal::STATUS_PROCESSING])
            ->sum('amount');

        $pendingCommissionsSum = (float) $agent->commissions()
            ->where('status', AgentCommission::STATUS_PENDING)
            ->sum('amount');

        $stats = [
            'wallet_balance'             => (float) $agent->wallet_balance,
            'total_earned_commission'    => (float) $agent->total_earned_commission,
            'total_withdrawn_commission' => (float) $agent->total_withdrawn_commission,
            'pending_commissions'        => $pendingCommissionsSum,
            'pending_withdrawals_sum'    => $pendingWithdrawalsSum,
            'total_commissions_count'    => $agent->commissions()->count(),
            'total_withdrawals_count'    => $agent->withdrawals()->count(),
            'doctor_rate'                => (float) $agent->doctor_commission_rate,
            'test_rate'                  => (float) $agent->test_commission_rate,
            'commission_type'            => $agent->commission_type,
        ];

        return Inertia::render('Agent/Wallet', [
            'agent'               => $agent,
            'commissions'         => $commissions,
            'withdrawals'         => $withdrawals,
            'transactions'        => $transactions,
            'stats'               => $stats,
            'activeTab'           => $tab,
            'minWithdrawalAmount' => $minWithdrawalAmount,
        ]);
    }

    public function requestWithdrawal(Request $request): RedirectResponse
    {
        $agent = $request->user()->agentProfile;
        if (!$agent || $agent->status !== AgentProfile::STATUS_ACTIVE) {
            return back()->with('error', 'Your agent account is currently not active for cash out.');
        }

        $minAmount = (float) GlobalSetting::get('agent_min_withdrawal_amount', 100.00);
        $maxBalance = (float) $agent->wallet_balance;

        if ($maxBalance < $minAmount) {
            return back()->with('error', "Insufficient wallet balance. Minimum cash out amount is BDT {$minAmount}.");
        }

        $validated = $request->validate([
            'amount'         => ['required', 'numeric', "min:{$minAmount}", "max:{$maxBalance}"],
            'payout_method'  => ['required', 'in:bkash,nagad,rocket,upay,bank'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_type'   => ['required', 'in:personal,agent'],
            'bank_name'      => ['nullable', 'string', 'max:150'],
            'bank_branch'    => ['nullable', 'string', 'max:150'],
            'bank_routing'   => ['nullable', 'string', 'max:50'],
            'account_name'   => ['nullable', 'string', 'max:150'],
        ]);

        $bankDetails = null;
        if ($validated['payout_method'] === 'bank') {
            $bankDetails = [
                'bank_name'     => $validated['bank_name'] ?? null,
                'branch'        => $validated['bank_branch'] ?? null,
                'routing'       => $validated['bank_routing'] ?? null,
                'account_name'  => $validated['account_name'] ?? null,
            ];
        }

        CommissionService::requestWithdrawal(
            $agent,
            (float) $validated['amount'],
            [
                'payout_method'  => $validated['payout_method'],
                'account_number' => $validated['account_number'],
                'account_type'   => $validated['account_type'],
                'bank_details'   => $bankDetails,
            ]
        );

        return back()->with('success', 'Cash out request of BDT ' . number_format($validated['amount'], 2) . ' submitted successfully. We will disburse the payment shortly.');
    }
}
