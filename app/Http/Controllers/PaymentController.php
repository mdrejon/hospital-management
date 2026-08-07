<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalTestBooking;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initiate online payment for an existing Appointment or Test Booking.
     */
    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'payable_type' => 'required|in:appointment,medical_test',
            'payable_id'   => 'required|integer',
            'gateway'      => 'required|in:sslcommerz,bkash',
            'return_url'   => 'nullable|string',
        ]);

        $payable = $validated['payable_type'] === 'appointment'
            ? Appointment::findOrFail($validated['payable_id'])
            : MedicalTestBooking::findOrFail($validated['payable_id']);

        $amount = $payable instanceof Appointment ? (float) $payable->fee : (float) $payable->total_amount;

        $payment = PaymentService::createPayment($payable, $validated['gateway'], $amount);

        $customer = [
            'name'    => $payable instanceof Appointment ? $payable->name : $payable->patient_name,
            'phone'   => $payable->phone,
            'email'   => $payable->email,
            'address' => 'Dhaka, Bangladesh',
        ];

        $result = PaymentService::processPayment($payment, $customer, $validated['return_url'] ?? url()->previous());

        return redirect($result['redirect_url']);
    }

    /**
     * Show Checkout simulator / gateway payment screen.
     */
    public function checkout(Request $request, Payment $payment)
    {
        $payable = $payment->payable;
        $returnUrl = $request->query('return_url');

        if (!$payable) {
            abort(404, 'Payable item not found.');
        }

        if ($payment->isSuccessful()) {
            return redirect()->route('payment.receipt', $payment->id);
        }

        $itemTitle = 'Medical Service Payment';
        $patientName = 'Patient';
        $phone = '';

        if ($payable instanceof Appointment) {
            $itemTitle = 'Doctor Appointment Consultation Fee';
            $patientName = $payable->name;
            $phone = $payable->phone;
        } elseif ($payable instanceof MedicalTestBooking) {
            $itemTitle = "Medical Diagnostic Test Booking ({$payable->booking_number})";
            $patientName = $payable->patient_name;
            $phone = $payable->phone;
        }

        return view('payment.checkout', [
            'payment'     => $payment,
            'payable'     => $payable,
            'itemTitle'   => $itemTitle,
            'patientName' => $patientName,
            'phone'       => $phone,
            'returnUrl'   => $returnUrl,
        ]);
    }

    /**
     * Process sandbox test transaction simulation.
     */
    public function processSandbox(Request $request, Payment $payment)
    {
        $action = $request->input('action', 'success'); // success, fail, cancel
        $returnUrl = $request->input('return_url');

        if ($action === 'success') {
            $trxID = 'SIM-' . strtoupper(uniqid());
            PaymentService::handlePaymentSuccess($payment, [
                'val_id'         => $trxID,
                'bank_tran_id'   => 'BNK-' . rand(100000, 999999),
                'card_type'      => $payment->gateway === Payment::GATEWAY_BKASH ? 'bKash Wallet' : 'VISA Debit (Sandbox)',
                'payment_method' => $payment->gateway,
                'simulated'      => true,
            ]);

            if ($returnUrl) {
                return redirect($returnUrl)->with('success', 'Payment of BDT ' . number_format($payment->amount, 2) . ' completed successfully!');
            }

            return redirect()->route('payment.receipt', $payment->id);
        }

        if ($action === 'cancel') {
            PaymentService::handlePaymentCancelled($payment);
            if ($returnUrl) {
                return redirect($returnUrl)->with('error', 'Payment transaction was cancelled.');
            }
            return redirect()->route('payment.cancelled', $payment->id);
        }

        PaymentService::handlePaymentFailed($payment, 'User or simulator declined transaction');
        if ($returnUrl) {
            return redirect($returnUrl)->with('error', 'Payment transaction failed.');
        }
        return redirect()->route('payment.failed', $payment->id);
    }

    /**
     * SSLCommerz Success Callback.
     */
    public function sslSuccess(Request $request)
    {
        $tranId = $request->input('tran_id');
        $valId  = $request->input('val_id');
        $amount = (float) $request->input('amount');
        $cardType = $request->input('card_type', 'SSLCommerz');
        $returnUrl = $request->input('value_b');

        $payment = Payment::where('transaction_id', $tranId)->first();

        if (!$payment) {
            return redirect('/')->with('error', 'Invalid payment transaction.');
        }

        // Validate via SSLCommerz API if live/sandbox mode
        $settings = PaymentService::getSettings();
        $storeId  = $settings['sslcommerz_store_id'];
        $storePwd = $settings['sslcommerz_store_password'];
        $isLive   = $settings['sslcommerz_mode'] === 'live';

        $valid = true;
        if (!empty($storeId) && !empty($storePwd) && !empty($valId)) {
            $validateUrl = $isLive
                ? "https://securepay.sslcommerz.com/validator/api/validationserverAPI.php?val_id={$valId}&store_id={$storeId}&store_passwd={$storePwd}&format=json"
                : "https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php?val_id={$valId}&store_id={$storeId}&store_passwd={$storePwd}&format=json";

            try {
                $resp = Http::timeout(10)->get($validateUrl);
                if ($resp->successful()) {
                    $json = $resp->json();
                    if (($json['status'] ?? '') !== 'VALID' && ($json['status'] ?? '') !== 'VALIDATED') {
                        $valid = false;
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('SSLCommerz validation error: ' . $e->getMessage());
            }
        }

        if ($valid) {
            PaymentService::handlePaymentSuccess($payment, [
                'val_id'         => $valId,
                'card_type'      => $cardType,
                'bank_tran_id'   => $request->input('bank_tran_id'),
                'card_brand'     => $request->input('card_brand'),
                'payment_method' => 'sslcommerz',
            ]);

            if (!empty($returnUrl)) {
                return redirect($returnUrl)->with('success', 'Payment received successfully!');
            }

            return redirect()->route('payment.receipt', $payment->id);
        }

        PaymentService::handlePaymentFailed($payment, 'SSLCommerz validation response status invalid');
        return redirect()->route('payment.failed', $payment->id);
    }

    /**
     * SSLCommerz Fail Callback.
     */
    public function sslFail(Request $request)
    {
        $tranId = $request->input('tran_id');
        $returnUrl = $request->input('value_b');

        if ($tranId) {
            $payment = Payment::where('transaction_id', $tranId)->first();
            if ($payment) {
                PaymentService::handlePaymentFailed($payment, $request->input('error', 'Transaction Failed'));
            }
        }

        if (!empty($returnUrl)) {
            return redirect($returnUrl)->with('error', 'Payment transaction failed. Please try again.');
        }

        return view('payment.failed', ['message' => 'Payment transaction was declined or failed.']);
    }

    /**
     * SSLCommerz Cancel Callback.
     */
    public function sslCancel(Request $request)
    {
        $tranId = $request->input('tran_id');
        $returnUrl = $request->input('value_b');

        if ($tranId) {
            $payment = Payment::where('transaction_id', $tranId)->first();
            if ($payment) {
                PaymentService::handlePaymentCancelled($payment);
            }
        }

        if (!empty($returnUrl)) {
            return redirect($returnUrl)->with('error', 'Payment transaction cancelled.');
        }

        return view('payment.cancelled', ['message' => 'You cancelled the payment process.']);
    }

    /**
     * SSLCommerz IPN (Instant Payment Notification).
     */
    public function sslIpn(Request $request)
    {
        $tranId = $request->input('tran_id');
        $status = $request->input('status');

        if ($tranId && $status === 'VALID') {
            $payment = Payment::where('transaction_id', $tranId)->first();
            if ($payment && !$payment->isSuccessful()) {
                PaymentService::handlePaymentSuccess($payment, $request->all());
            }
        }

        return response()->json(['status' => 'IPN Processed']);
    }

    /**
     * bKash Callback.
     */
    public function bkashCallback(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $status    = $request->query('status');
        $returnUrl = $request->query('return_url');

        $payment = Payment::find($paymentId);
        if (!$payment) {
            return redirect('/')->with('error', 'Payment not found');
        }

        if ($status === 'success') {
            PaymentService::handlePaymentSuccess($payment, [
                'val_id'         => $request->query('paymentID'),
                'payment_method' => 'bkash',
            ]);

            if (!empty($returnUrl)) {
                return redirect($returnUrl)->with('success', 'bKash payment received successfully!');
            }

            return redirect()->route('payment.receipt', $payment->id);
        }

        if ($status === 'cancel') {
            PaymentService::handlePaymentCancelled($payment);
            if (!empty($returnUrl)) {
                return redirect($returnUrl)->with('error', 'bKash payment cancelled.');
            }
            return redirect()->route('payment.cancelled', $payment->id);
        }

        PaymentService::handlePaymentFailed($payment, 'bKash transaction declined or failed');
        if (!empty($returnUrl)) {
            return redirect($returnUrl)->with('error', 'bKash payment failed.');
        }
        return redirect()->route('payment.failed', $payment->id);
    }

    /**
     * Payment Receipt / Confirmation View.
     */
    public function receipt(Payment $payment)
    {
        $payable = $payment->payable;

        return view('payment.receipt', [
            'payment' => $payment,
            'payable' => $payable,
        ]);
    }

    /**
     * Payment Failed View.
     */
    public function failed(Payment $payment)
    {
        return view('payment.failed', [
            'payment' => $payment,
            'message' => 'Your payment could not be processed.',
        ]);
    }

    /**
     * Payment Cancelled View.
     */
    public function cancelled(Payment $payment)
    {
        return view('payment.cancelled', [
            'payment' => $payment,
            'message' => 'The payment transaction was cancelled.',
        ]);
    }
}
