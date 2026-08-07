<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentCommission;
use App\Models\AgentProfile;
use App\Models\AgentWalletTransaction;
use App\Models\AgentWithdrawal;
use App\Models\Role;
use App\Models\User;
use App\Services\CommissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AgentController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = AgentProfile::with(['user'])
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('agent_code', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('nid_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest();

        $agents = $query->paginate(15)->withQueryString();

        $stats = [
            'total_agents'          => AgentProfile::count(),
            'active_agents'         => AgentProfile::where('status', AgentProfile::STATUS_ACTIVE)->count(),
            'pending_approvals'     => AgentProfile::where('status', AgentProfile::STATUS_PENDING)->count(),
            'total_wallet_balance'  => (float) AgentProfile::sum('wallet_balance'),
            'total_commission_paid' => (float) AgentProfile::sum('total_withdrawn_commission'),
        ];

        return Inertia::render('Admin/Agents/Index', [
            'agents'  => $agents,
            'filters' => [
                'search' => $search,
                'status' => $status,
            ],
            'stats'   => $stats,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Agents/Create', [
            'nextAgentCode' => AgentProfile::generateCode(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                   => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'               => ['required', 'string', 'min:8'],
            'phone'                  => ['required', 'string', 'max:30'],
            'nid_number'             => ['nullable', 'string', 'max:50'],
            'address'                => ['nullable', 'string'],
            'city'                   => ['nullable', 'string', 'max:100'],
            'commission_type'        => ['required', 'in:percentage,fixed'],
            'doctor_commission_rate' => ['required', 'numeric', 'min:0'],
            'test_commission_rate'   => ['required', 'numeric', 'min:0'],
            'payout_method'          => ['required', 'in:bkash,nagad,rocket,upay,bank'],
            'payout_account_number'  => ['nullable', 'string', 'max:50'],
            'payout_account_type'    => ['required', 'in:personal,agent'],
            'bank_name'              => ['nullable', 'string', 'max:150'],
            'bank_branch'            => ['nullable', 'string', 'max:150'],
            'bank_routing'           => ['nullable', 'string', 'max:50'],
            'bank_account_name'      => ['nullable', 'string', 'max:150'],
            'status'                 => ['required', 'in:pending,active,suspended,rejected'],
            'notes'                  => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $agentRole = Role::firstOrCreate(['slug' => 'agent'], [
                'name'           => 'Agent',
                'description'    => 'Medical & Doctor Booking Agent',
                'is_super_admin' => false,
                'is_active'      => true,
            ]);

            $user = User::create([
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'role_id'   => $agentRole->id,
                'is_active' => $validated['status'] === 'active',
            ]);

            $bankDetails = null;
            if ($validated['payout_method'] === 'bank') {
                $bankDetails = [
                    'bank_name'     => $validated['bank_name'] ?? null,
                    'branch'        => $validated['bank_branch'] ?? null,
                    'routing'       => $validated['bank_routing'] ?? null,
                    'account_name'  => $validated['bank_account_name'] ?? null,
                ];
            }

            AgentProfile::create([
                'user_id'                => $user->id,
                'agent_code'             => AgentProfile::generateCode(),
                'phone'                  => $validated['phone'],
                'nid_number'             => $validated['nid_number'] ?? null,
                'address'                => $validated['address'] ?? null,
                'city'                   => $validated['city'] ?? null,
                'commission_type'        => $validated['commission_type'],
                'doctor_commission_rate' => $validated['doctor_commission_rate'],
                'test_commission_rate'   => $validated['test_commission_rate'],
                'payout_method'          => $validated['payout_method'],
                'payout_account_number'  => $validated['payout_account_number'] ?? null,
                'payout_account_type'    => $validated['payout_account_type'],
                'bank_details'           => $bankDetails,
                'status'                 => $validated['status'],
                'approved_by'            => $validated['status'] === 'active' ? $request->user()->id : null,
                'approved_at'            => $validated['status'] === 'active' ? now() : null,
                'notes'                  => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('admin.agents.index')->with('success', 'Agent created successfully.');
    }

    public function show(AgentProfile $agent): Response
    {
        $agent->load(['user', 'approver']);

        $recentAppointments = $agent->appointments()
            ->with(['doctor', 'patient'])
            ->latest()
            ->take(10)
            ->get();

        $recentTestBookings = $agent->medicalTestBookings()
            ->with(['items'])
            ->latest()
            ->take(10)
            ->get();

        $recentWithdrawals = $agent->withdrawals()
            ->latest()
            ->take(10)
            ->get();

        $recentLedger = $agent->walletTransactions()
            ->latest()
            ->take(15)
            ->get();

        $stats = [
            'total_appointments'  => $agent->appointments()->count(),
            'total_tests_booked'  => $agent->medicalTestBookings()->count(),
            'wallet_balance'      => (float) $agent->wallet_balance,
            'total_earned'        => (float) $agent->total_earned_commission,
            'total_withdrawn'     => (float) $agent->total_withdrawn_commission,
            'pending_commissions' => (float) $agent->commissions()->where('status', 'pending')->sum('amount'),
        ];

        return Inertia::render('Admin/Agents/Show', [
            'agent'              => $agent,
            'recentAppointments' => $recentAppointments,
            'recentTestBookings' => $recentTestBookings,
            'recentWithdrawals'  => $recentWithdrawals,
            'recentLedger'       => $recentLedger,
            'stats'              => $stats,
        ]);
    }

    public function edit(AgentProfile $agent): Response
    {
        $agent->load('user');

        return Inertia::render('Admin/Agents/Edit', [
            'agent' => $agent,
        ]);
    }

    public function update(Request $request, AgentProfile $agent): RedirectResponse
    {
        $user = $agent->user;

        $validated = $request->validate([
            'name'                   => ['required', 'string', 'max:255'],
            'email'                  => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password'               => ['nullable', 'string', 'min:8'],
            'phone'                  => ['required', 'string', 'max:30'],
            'nid_number'             => ['nullable', 'string', 'max:50'],
            'address'                => ['nullable', 'string'],
            'city'                   => ['nullable', 'string', 'max:100'],
            'commission_type'        => ['required', 'in:percentage,fixed'],
            'doctor_commission_rate' => ['required', 'numeric', 'min:0'],
            'test_commission_rate'   => ['required', 'numeric', 'min:0'],
            'payout_method'          => ['required', 'in:bkash,nagad,rocket,upay,bank'],
            'payout_account_number'  => ['nullable', 'string', 'max:50'],
            'payout_account_type'    => ['required', 'in:personal,agent'],
            'bank_name'              => ['nullable', 'string', 'max:150'],
            'bank_branch'            => ['nullable', 'string', 'max:150'],
            'bank_routing'           => ['nullable', 'string', 'max:50'],
            'bank_account_name'      => ['nullable', 'string', 'max:150'],
            'status'                 => ['required', 'in:pending,active,suspended,rejected'],
            'notes'                  => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $user, $agent, $request) {
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->is_active = $validated['status'] === 'active';
            $user->save();

            $bankDetails = null;
            if ($validated['payout_method'] === 'bank') {
                $bankDetails = [
                    'bank_name'     => $validated['bank_name'] ?? null,
                    'branch'        => $validated['bank_branch'] ?? null,
                    'routing'       => $validated['bank_routing'] ?? null,
                    'account_name'  => $validated['bank_account_name'] ?? null,
                ];
            }

            $becameActive = $agent->status !== 'active' && $validated['status'] === 'active';

            $agent->update([
                'phone'                  => $validated['phone'],
                'nid_number'             => $validated['nid_number'] ?? null,
                'address'                => $validated['address'] ?? null,
                'city'                   => $validated['city'] ?? null,
                'commission_type'        => $validated['commission_type'],
                'doctor_commission_rate' => $validated['doctor_commission_rate'],
                'test_commission_rate'   => $validated['test_commission_rate'],
                'payout_method'          => $validated['payout_method'],
                'payout_account_number'  => $validated['payout_account_number'] ?? null,
                'payout_account_type'    => $validated['payout_account_type'],
                'bank_details'           => $bankDetails,
                'status'                 => $validated['status'],
                'approved_by'            => $becameActive ? $request->user()->id : $agent->approved_by,
                'approved_at'            => $becameActive ? now() : $agent->approved_at,
                'notes'                  => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('admin.agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(AgentProfile $agent): RedirectResponse
    {
        DB::transaction(function () use ($agent) {
            $user = $agent->user;
            $agent->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.agents.index')->with('success', 'Agent removed successfully.');
    }

    public function adjustBalance(Request $request, AgentProfile $agent): RedirectResponse
    {
        $validated = $request->validate([
            'type'        => ['required', 'in:adjustment_credit,adjustment_debit'],
            'amount'      => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $amount = (float) $validated['amount'];
        $type = $validated['type'];

        DB::transaction(function () use ($agent, $amount, $type, $validated) {
            $balanceBefore = (float) $agent->wallet_balance;

            if ($type === 'adjustment_credit') {
                $balanceAfter = round($balanceBefore + $amount, 2);
                $agent->total_earned_commission = round((float) $agent->total_earned_commission + $amount, 2);
            } else {
                if ($balanceBefore < $amount) {
                    throw new \Exception('Insufficient wallet balance for debit adjustment.');
                }
                $balanceAfter = round($balanceBefore - $amount, 2);
            }

            $agent->wallet_balance = $balanceAfter;
            $agent->saveQuietly();

            AgentWalletTransaction::create([
                'agent_id'       => $agent->id,
                'type'           => $type,
                'amount'         => $amount,
                'balance_before' => $balanceBefore,
                'balance_after'  => $balanceAfter,
                'description'    => $validated['description'],
            ]);
        });

        return back()->with('success', 'Agent wallet balance adjusted.');
    }
}
