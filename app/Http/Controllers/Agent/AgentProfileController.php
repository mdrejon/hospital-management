<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AgentProfileController extends Controller
{
    public function show(Request $request): Response
    {
        $user = $request->user();
        $agent = $user->agentProfile;

        return Inertia::render('Agent/Profile', [
            'agent' => $agent,
            'user'  => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $agent = $user->agentProfile;

        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'                 => ['required', 'string', 'max:30'],
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
            'current_password'      => ['nullable', 'required_with:password', 'current_password'],
            'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        if ($request->hasFile('nid_file')) {
            if ($agent->nid_file && Storage::disk('public')->exists($agent->nid_file)) {
                Storage::disk('public')->delete($agent->nid_file);
            }
            $agent->nid_file = $request->file('nid_file')->store('agent-docs', 'public');
        }

        $bankDetails = null;
        if ($validated['payout_method'] === 'bank') {
            $bankDetails = [
                'bank_name'     => $validated['bank_name'] ?? null,
                'branch'        => $validated['bank_branch'] ?? null,
                'routing'       => $validated['bank_routing'] ?? null,
                'account_name'  => $validated['bank_account_name'] ?? null,
            ];
        }

        $agent->phone                  = $validated['phone'];
        $agent->nid_number             = $validated['nid_number'] ?? null;
        $agent->address                = $validated['address'] ?? null;
        $agent->city                   = $validated['city'] ?? null;
        $agent->payout_method          = $validated['payout_method'];
        $agent->payout_account_number  = $validated['payout_account_number'] ?? null;
        $agent->payout_account_type    = $validated['payout_account_type'];
        $agent->bank_details           = $bankDetails;
        $agent->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
