<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentGatewaySettingController extends Controller
{
    public function edit(): Response
    {
        $settings = [
            'payment_allow_without_pay' => (bool) GlobalSetting::get('payment_allow_without_pay', 1),
            'payment_currency'          => GlobalSetting::get('payment_currency', 'BDT'),
            'sslcommerz_enabled'        => (bool) GlobalSetting::get('sslcommerz_enabled', 0),
            'sslcommerz_store_id'       => GlobalSetting::get('sslcommerz_store_id', ''),
            'sslcommerz_store_password' => GlobalSetting::get('sslcommerz_store_password', ''),
            'sslcommerz_mode'           => GlobalSetting::get('sslcommerz_mode', 'sandbox'),
            'bkash_enabled'             => (bool) GlobalSetting::get('bkash_enabled', 0),
            'bkash_app_key'             => GlobalSetting::get('bkash_app_key', ''),
            'bkash_app_secret'          => GlobalSetting::get('bkash_app_secret', ''),
            'bkash_username'            => GlobalSetting::get('bkash_username', ''),
            'bkash_password'            => GlobalSetting::get('bkash_password', ''),
            'bkash_mode'                => GlobalSetting::get('bkash_mode', 'sandbox'),
        ];

        $transactions = Payment::with('payable')
            ->latest()
            ->paginate(15);

        return Inertia::render('Admin/WebsiteSettings/PaymentGateways/Edit', [
            'settings'     => $settings,
            'transactions' => $transactions,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_allow_without_pay' => ['required', 'boolean'],
            'payment_currency'          => ['required', 'string', 'max:10'],
            'sslcommerz_enabled'        => ['required', 'boolean'],
            'sslcommerz_store_id'       => ['nullable', 'string', 'max:191'],
            'sslcommerz_store_password' => ['nullable', 'string', 'max:191'],
            'sslcommerz_mode'           => ['required', 'in:sandbox,live'],
            'bkash_enabled'             => ['required', 'boolean'],
            'bkash_app_key'             => ['nullable', 'string', 'max:191'],
            'bkash_app_secret'          => ['nullable', 'string', 'max:191'],
            'bkash_username'            => ['nullable', 'string', 'max:191'],
            'bkash_password'            => ['nullable', 'string', 'max:191'],
            'bkash_mode'                => ['required', 'in:sandbox,live'],
        ]);

        GlobalSetting::setMany([
            'payment_allow_without_pay' => $validated['payment_allow_without_pay'] ? '1' : '0',
            'payment_currency'          => $validated['payment_currency'],
            'sslcommerz_enabled'        => $validated['sslcommerz_enabled'] ? '1' : '0',
            'sslcommerz_store_id'       => $validated['sslcommerz_store_id'] ?? '',
            'sslcommerz_store_password' => $validated['sslcommerz_store_password'] ?? '',
            'sslcommerz_mode'           => $validated['sslcommerz_mode'],
            'bkash_enabled'             => $validated['bkash_enabled'] ? '1' : '0',
            'bkash_app_key'             => $validated['bkash_app_key'] ?? '',
            'bkash_app_secret'          => $validated['bkash_app_secret'] ?? '',
            'bkash_username'            => $validated['bkash_username'] ?? '',
            'bkash_password'            => $validated['bkash_password'] ?? '',
            'bkash_mode'                => $validated['bkash_mode'],
        ]);

        return back()->with('success', 'Payment gateway configuration updated successfully.');
    }
}
