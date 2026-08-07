<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\GlobalSetting;
use App\Models\MedicalTestBooking;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Get payment gateway settings.
     */
    public static function getSettings(): array
    {
        return [
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
    }

    /**
     * Get list of active payment gateways available for customers/agents.
     */
    public static function getActiveGateways(): array
    {
        $settings = self::getSettings();
        $gateways = [];

        if ($settings['bkash_enabled']) {
            $gateways['bkash'] = [
                'key'         => 'bkash',
                'name'        => 'bKash Online Payment',
                'logo'        => '/assets/img/bkash.png',
                'description' => 'Instant & secure bKash direct wallet payment',
                'mode'        => $settings['bkash_mode'],
            ];
        }

        if ($settings['sslcommerz_enabled']) {
            $gateways['sslcommerz'] = [
                'key'         => 'sslcommerz',
                'name'        => 'SSLCommerz (Cards / MFS / Net Banking)',
                'logo'        => '/assets/img/sslcommerz.png',
                'description' => 'Visa, MasterCard, Nagad, Rocket, Islami Bank & 30+ Banks',
                'mode'        => $settings['sslcommerz_mode'],
            ];
        }

        return [
            'allow_without_pay' => $settings['payment_allow_without_pay'],
            'currency'          => $settings['payment_currency'],
            'gateways'          => $gateways,
            'has_online'        => count($gateways) > 0,
        ];
    }

    /**
     * Create a pending Payment record for any payable model.
     */
    public static function createPayment(Model $payable, string $gateway, float $amount, ?string $currency = null): Payment
    {
        $currency = $currency ?: GlobalSetting::get('payment_currency', 'BDT');
        $prefix = strtoupper(substr($gateway, 0, 3));
        $txnId = $prefix . '-' . date('YmdHis') . '-' . strtoupper(Str::random(6));

        return Payment::create([
            'payable_type'   => get_class($payable),
            'payable_id'     => $payable->id,
            'gateway'        => $gateway,
            'transaction_id' => $txnId,
            'currency'       => $currency,
            'amount'         => max(0, $amount),
            'status'         => Payment::STATUS_PENDING,
        ]);
    }

    /**
     * Process checkout initialization for a Payment record.
     */
    public static function processPayment(Payment $payment, array $customerData, ?string $returnUrl = null): array
    {
        if ($payment->gateway === Payment::GATEWAY_SSLCOMMERZ) {
            return self::initiateSslcommerz($payment, $customerData, $returnUrl);
        }

        if ($payment->gateway === Payment::GATEWAY_BKASH) {
            return self::initiateBkash($payment, $customerData, $returnUrl);
        }

        return [
            'success'      => true,
            'redirect_url' => route('payment.checkout', $payment->id),
        ];
    }

    /**
     * Initialize SSLCommerz Payment.
     */
    public static function initiateSslcommerz(Payment $payment, array $customer, ?string $returnUrl = null): array
    {
        $settings = self::getSettings();
        $storeId  = $settings['sslcommerz_store_id'];
        $storePwd = $settings['sslcommerz_store_password'];
        $isLive   = $settings['sslcommerz_mode'] === 'live';

        $apiUrl = $isLive
            ? 'https://securepay.sslcommerz.com/gwprocess/v4/api.php'
            : 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php';

        $postData = [
            'store_id'         => $storeId,
            'store_passwd'     => $storePwd,
            'total_amount'     => number_format((float) $payment->amount, 2, '.', ''),
            'currency'         => $payment->currency ?: 'BDT',
            'tran_id'          => $payment->transaction_id,
            'success_url'      => route('payment.sslcommerz.success'),
            'fail_url'         => route('payment.sslcommerz.fail'),
            'cancel_url'       => route('payment.sslcommerz.cancel'),
            'ipn_url'          => route('payment.sslcommerz.ipn'),
            'cus_name'         => $customer['name'] ?? 'Patient',
            'cus_email'        => !empty($customer['email']) ? $customer['email'] : 'patient@hospital.com',
            'cus_add1'         => $customer['address'] ?? 'Dhaka, Bangladesh',
            'cus_city'         => 'Dhaka',
            'cus_country'      => 'Bangladesh',
            'cus_phone'        => $customer['phone'] ?? '01700000000',
            'shipping_method'  => 'NO',
            'num_of_item'      => 1,
            'product_name'     => 'Healthcare / Consultation / Diagnostic Service',
            'product_category' => 'Healthcare',
            'product_profile'  => 'general',
            'value_a'          => $payment->id,
            'value_b'          => $returnUrl ?? '',
        ];

        // Attempt live SSLCommerz connection if credentials are configured
        if (!empty($storeId) && !empty($storePwd) && $storeId !== 'demo' && $storeId !== 'test') {
            try {
                $response = Http::asForm()->timeout(15)->post($apiUrl, $postData);
                if ($response->successful()) {
                    $json = $response->json();
                    if (!empty($json['status']) && $json['status'] === 'SUCCESS' && !empty($json['GatewayPageURL'])) {
                        return [
                            'success'      => true,
                            'redirect_url' => $json['GatewayPageURL'],
                        ];
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('SSLCommerz API request failed: ' . $e->getMessage());
            }
        }

        // Fallback to our interactive simulator payment page
        return [
            'success'      => true,
            'redirect_url' => route('payment.checkout', ['payment' => $payment->id, 'return_url' => $returnUrl]),
        ];
    }

    /**
     * Initialize bKash Payment.
     */
    public static function initiateBkash(Payment $payment, array $customer, ?string $returnUrl = null): array
    {
        $settings = self::getSettings();
        $appKey   = $settings['bkash_app_key'];
        $appSec   = $settings['bkash_app_secret'];
        $isLive   = $settings['bkash_mode'] === 'live';

        $baseUrl = $isLive
            ? 'https://tokenized.pay.bka.sh/v1.2.0-beta'
            : 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';

        if (!empty($appKey) && !empty($appSec) && $appKey !== 'demo' && $appKey !== 'test') {
            try {
                // 1. Grant Token
                $tokenRes = Http::withHeaders([
                    'username' => $settings['bkash_username'],
                    'password' => $settings['bkash_password'],
                ])->post("{$baseUrl}/tokenized/checkout/token/grant", [
                    'app_key'    => $appKey,
                    'app_secret' => $appSec,
                ]);

                if ($tokenRes->successful() && !empty($tokenRes['id_token'])) {
                    $idToken = $tokenRes['id_token'];

                    // 2. Create Payment
                    $createRes = Http::withHeaders([
                        'Authorization' => $idToken,
                        'X-APP-Key'     => $appKey,
                    ])->post("{$baseUrl}/tokenized/checkout/create", [
                        'mode'                  => '0011',
                        'payerReference'        => $customer['phone'] ?? '01700000000',
                        'callbackURL'           => route('payment.bkash.callback', ['payment_id' => $payment->id, 'return_url' => $returnUrl]),
                        'amount'                => number_format((float) $payment->amount, 2, '.', ''),
                        'currency'              => 'BDT',
                        'intent'                => 'sale',
                        'merchantInvoiceNumber' => $payment->transaction_id,
                    ]);

                    if ($createRes->successful() && !empty($createRes['bkashURL'])) {
                        $payment->update([
                            'val_id' => $createRes['paymentID'] ?? null,
                        ]);

                        return [
                            'success'      => true,
                            'redirect_url' => $createRes['bkashURL'],
                        ];
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('bKash Tokenized request failed: ' . $e->getMessage());
            }
        }

        // Fallback to simulator checkout screen
        return [
            'success'      => true,
            'redirect_url' => route('payment.checkout', ['payment' => $payment->id, 'return_url' => $returnUrl]),
        ];
    }

    /**
     * Mark payment as successful and apply to underlying Appointment / Test Booking.
     */
    public static function handlePaymentSuccess(Payment $payment, array $details = []): bool
    {
        if ($payment->isSuccessful()) {
            return true;
        }

        $payment->status          = Payment::STATUS_SUCCESSFUL;
        $payment->paid_at         = now();
        $payment->val_id          = $details['val_id'] ?? $details['bank_tran_id'] ?? $details['trxID'] ?? $payment->val_id;
        $payment->payment_method  = $details['card_type'] ?? $details['payment_method'] ?? $payment->gateway;
        $payment->payment_details = array_merge($payment->payment_details ?? [], $details);
        $payment->save();

        $payable = $payment->payable;
        if (!$payable) {
            return true;
        }

        if ($payable instanceof Appointment) {
            $payable->payment_status = 'paid';
            $payable->paid_amount    = $payment->amount;
            $payable->payment_method = $payment->gateway;
            $payable->saveQuietly();

            // Handle Agent Commission & Wallet Credit
            if ($payable->agent_id) {
                $commission = CommissionService::handleAppointmentCommission($payable);
                if ($commission && $payable->agent) {
                    CommissionService::creditWallet(
                        $payable->agent,
                        (float) $commission->amount,
                        $commission,
                        "Commission for online paid Doctor appointment #{$payable->id}"
                    );
                }
            }

            // Send SMS to Patient
            try {
                SmsService::sendAppointmentConfirmation($payable);
            } catch (\Throwable $e) {
                Log::warning('Appointment SMS failed: ' . $e->getMessage());
            }
        } elseif ($payable instanceof MedicalTestBooking) {
            $payable->payment_status = MedicalTestBooking::PAYMENT_PAID;
            $payable->paid_amount    = $payment->amount;
            $payable->due_amount     = 0.00;
            $payable->payment_method = $payment->gateway;
            $payable->saveQuietly();

            // Handle Agent Commission & Wallet Credit
            if ($payable->agent_id) {
                $commission = CommissionService::handleMedicalTestCommission($payable);
                if ($commission && $payable->agent) {
                    CommissionService::creditWallet(
                        $payable->agent,
                        (float) $commission->amount,
                        $commission,
                        "Commission for online paid Medical test booking {$payable->booking_number}"
                    );
                }
            }

            // Send SMS to Patient
            try {
                SmsService::sendTestBookingConfirmation($payable);
            } catch (\Throwable $e) {
                Log::warning('Medical Test Booking SMS failed: ' . $e->getMessage());
            }
        }

        return true;
    }

    /**
     * Mark payment as failed.
     */
    public static function handlePaymentFailed(Payment $payment, string $reason = 'Payment transaction failed'): void
    {
        $payment->status = Payment::STATUS_FAILED;
        $details = $payment->payment_details ?? [];
        $details['failure_reason'] = $reason;
        $payment->payment_details = $details;
        $payment->save();
    }

    /**
     * Mark payment as cancelled.
     */
    public static function handlePaymentCancelled(Payment $payment): void
    {
        $payment->status = Payment::STATUS_CANCELLED;
        $payment->save();
    }
}
