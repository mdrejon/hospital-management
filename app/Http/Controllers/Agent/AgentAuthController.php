<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentProfile;
use App\Models\GlobalSetting;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class AgentAuthController extends Controller
{
    public function showRegister(): Response
    {
        return Inertia::render('Agent/Register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'                 => ['required', 'string', 'max:30'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'nid_number'            => ['nullable', 'string', 'max:50'],
            'nid_file'              => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'address'               => ['nullable', 'string'],
            'city'                  => ['nullable', 'string', 'max:100'],
            'payout_method'         => ['required', 'in:bkash,nagad,rocket,upay,bank'],
            'payout_account_number' => ['nullable', 'string', 'max:50'],
            'payout_account_type'   => ['required', 'in:personal,agent'],
            'bank_name'             => ['nullable', 'string', 'max:150'],
            'bank_branch'           => ['nullable', 'string', 'max:150'],
            'bank_routing'          => ['nullable', 'string', 'max:50'],
            'bank_account_name'     => ['nullable', 'string', 'max:150'],
        ]);

        $user = DB::transaction(function () use ($validated, $request) {
            $agentRole = Role::firstOrCreate(['slug' => 'agent'], [
                'name'           => 'Agent',
                'description'    => 'Medical & Doctor Booking Agent',
                'is_super_admin' => false,
                'is_active'      => true,
            ]);

            $nidFilePath = null;
            if ($request->hasFile('nid_file')) {
                $nidFilePath = $request->file('nid_file')->store('agent-docs', 'public');
            }

            $user = User::create([
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'role_id'   => $agentRole->id,
                'is_active' => true,
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

            $defaultDoctorRate = (float) GlobalSetting::get('agent_default_doctor_commission_rate', 10.00);
            $defaultTestRate   = (float) GlobalSetting::get('agent_default_test_commission_rate', 15.00);

            AgentProfile::create([
                'user_id'                => $user->id,
                'agent_code'             => AgentProfile::generateCode(),
                'phone'                  => $validated['phone'],
                'nid_number'             => $validated['nid_number'] ?? null,
                'nid_file'               => $nidFilePath,
                'address'                => $validated['address'] ?? null,
                'city'                   => $validated['city'] ?? null,
                'commission_type'        => 'percentage',
                'doctor_commission_rate' => $defaultDoctorRate,
                'test_commission_rate'   => $defaultTestRate,
                'wallet_balance'         => 0.00,
                'payout_method'          => $validated['payout_method'],
                'payout_account_number'  => $validated['payout_account_number'] ?? null,
                'payout_account_type'    => $validated['payout_account_type'],
                'bank_details'           => $bankDetails,
                'status'                 => AgentProfile::STATUS_ACTIVE, // Activated so agent can immediately work
                'approved_at'            => now(),
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('agent.dashboard')
            ->with('success', 'Welcome! Your Agent account has been registered successfully.');
    }
}
