<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentWithdrawal;
use App\Services\CommissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AgentWithdrawalController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $query = AgentWithdrawal::with(['agent.user', 'processedBy'])
            ->when($status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('withdrawal_number', 'like', "%{$search}%")
                        ->orWhere('account_number', 'like', "%{$search}%")
                        ->orWhere('transaction_id', 'like', "%{$search}%")
                        ->orWhereHas('agent.user', function ($uq) use ($search) {
                            $uq->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest();

        $withdrawals = $query->paginate(15)->withQueryString();

        $stats = [
            'total_requests'       => AgentWithdrawal::count(),
            'pending_count'        => AgentWithdrawal::whereIn('status', [AgentWithdrawal::STATUS_PENDING, AgentWithdrawal::STATUS_PROCESSING])->count(),
            'pending_amount'       => (float) AgentWithdrawal::whereIn('status', [AgentWithdrawal::STATUS_PENDING, AgentWithdrawal::STATUS_PROCESSING])->sum('amount'),
            'approved_count'       => AgentWithdrawal::where('status', AgentWithdrawal::STATUS_APPROVED)->count(),
            'approved_amount'      => (float) AgentWithdrawal::where('status', AgentWithdrawal::STATUS_APPROVED)->sum('amount'),
            'total_wallet_balance' => (float) \App\Models\AgentProfile::where('status', 'active')->sum('wallet_balance'),
        ];

        return Inertia::render('Admin/Withdrawals/Index', [
            'withdrawals' => $withdrawals,
            'filters'     => [
                'status' => $status,
                'search' => $search,
            ],
            'stats'       => $stats,
        ]);
    }

    public function approve(Request $request, AgentWithdrawal $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== AgentWithdrawal::STATUS_PENDING && $withdrawal->status !== AgentWithdrawal::STATUS_PROCESSING) {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        $validated = $request->validate([
            'transaction_id' => ['nullable', 'string', 'max:100'],
            'admin_notes'    => ['nullable', 'string'],
        ]);

        CommissionService::approveWithdrawal(
            $withdrawal,
            $validated['transaction_id'] ?? null,
            $validated['admin_notes'] ?? null,
            $request->user()->id
        );

        return back()->with('success', "Withdrawal #{$withdrawal->withdrawal_number} approved and marked as paid.");
    }

    public function reject(Request $request, AgentWithdrawal $withdrawal): RedirectResponse
    {
        if ($withdrawal->status !== AgentWithdrawal::STATUS_PENDING && $withdrawal->status !== AgentWithdrawal::STATUS_PROCESSING) {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        $validated = $request->validate([
            'admin_notes' => ['required', 'string', 'max:500'],
        ]);

        CommissionService::rejectWithdrawal(
            $withdrawal,
            $validated['admin_notes'],
            $request->user()->id
        );

        return back()->with('success', "Withdrawal #{$withdrawal->withdrawal_number} rejected and funds refunded to agent wallet.");
    }
}
