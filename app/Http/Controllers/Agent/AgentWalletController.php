<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentCommission;
use App\Models\AgentProfile;
use App\Models\AgentWithdrawal;
use App\Models\GlobalSetting;
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
