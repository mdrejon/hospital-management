<?php

namespace App\Services;

use App\Models\AgentProfile;
use App\Models\AgentWithdrawal;
use App\Models\Appointment;
use App\Models\GlobalSetting;
use App\Models\MedicalTestBooking;
use App\Models\SmsLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an arbitrary SMS and log the outcome.
     */
    public static function send(string $phone, string $message, string $eventType = 'custom'): array
    {
        $phone = trim($phone);
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Empty phone number'];
        }

        // Standardize Bangladesh phone numbers (e.g., 017xxxxxxxx -> 88017xxxxxxxx)
        $normalizedPhone = self::normalizeBdPhone($phone);

        $enabled = GlobalSetting::get('sms_enabled', '0') === '1';
        $provider = GlobalSetting::get('sms_provider', 'generic_http');
        $apiUrl = GlobalSetting::get('sms_api_url', '');
        $apiKey = GlobalSetting::get('sms_api_key', '');
        $senderId = GlobalSetting::get('sms_sender_id', 'HOSPITAL');
        $clientId = GlobalSetting::get('sms_client_id', '');
        $method = strtoupper(GlobalSetting::get('sms_method', 'GET'));

        // If SMS is disabled or no API URL is configured, log as simulated/queued
        if (!$enabled || empty($apiUrl)) {
            SmsLog::create([
                'recipient_phone'  => $normalizedPhone,
                'message'          => $message,
                'event_type'       => $eventType,
                'provider'         => $provider . ' (simulated)',
                'status'           => 'sent',
                'gateway_response' => 'SMS Gateway disabled or simulated mode. Message logged successfully.',
            ]);

            return ['success' => true, 'simulated' => true, 'message' => 'Logged in simulated mode'];
        }

        try {
            $response = null;

            if ($provider === 'ssl_wireless') {
                // SSL Wireless BD API format
                $payload = [
                    'api_token' => $apiKey,
                    'sid'       => $senderId,
                    'msisdn'    => $normalizedPhone,
                    'sms'       => $message,
                    'csms_id'   => uniqid('CSMS_'),
                ];
                $response = Http::timeout(10)->post($apiUrl, $payload);
            } elseif ($provider === 'greenweb') {
                // Greenweb BD SMS API
                $url = $apiUrl . '?' . http_build_query([
                    'token' => $apiKey,
                    'to'    => $normalizedPhone,
                    'message' => $message,
                ]);
                $response = Http::timeout(10)->get($url);
            } elseif ($provider === 'bulksms_bd') {
                // BulkSMS BD
                $payload = [
                    'api_key'  => $apiKey,
                    'senderid' => $senderId,
                    'number'   => $normalizedPhone,
                    'message'  => $message,
                ];
                $response = Http::timeout(10)->post($apiUrl, $payload);
            } else {
                // Generic HTTP Provider with dynamic placeholder replacement
                $processedUrl = str_replace(
                    ['{phone}', '{to}', '{message}', '{msg}', '{apikey}', '{api_key}', '{sender_id}'],
                    [urlencode($normalizedPhone), urlencode($normalizedPhone), urlencode($message), urlencode($message), $apiKey, $apiKey, urlencode($senderId)],
                    $apiUrl
                );

                if ($method === 'POST') {
                    $response = Http::timeout(10)->asForm()->post($processedUrl, [
                        'api_key'  => $apiKey,
                        'to'       => $normalizedPhone,
                        'message'  => $message,
                        'sender_id'=> $senderId,
                        'client_id'=> $clientId,
                    ]);
                } else {
                    $response = Http::timeout(10)->get($processedUrl);
                }
            }

            $isSuccess = $response && $response->successful();
            $body = $response ? $response->body() : 'No response from gateway';

            SmsLog::create([
                'recipient_phone'  => $normalizedPhone,
                'message'          => $message,
                'event_type'       => $eventType,
                'provider'         => $provider,
                'status'           => $isSuccess ? 'sent' : 'failed',
                'gateway_response' => substr($body, 0, 1000),
            ]);

            return ['success' => $isSuccess, 'response' => $body];
        } catch (\Throwable $e) {
            Log::error('SMS Gateway Dispatch Error: ' . $e->getMessage());

            SmsLog::create([
                'recipient_phone'  => $normalizedPhone,
                'message'          => $message,
                'event_type'       => $eventType,
                'provider'         => $provider,
                'status'           => 'failed',
                'gateway_response' => 'Exception: ' . $e->getMessage(),
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Send Appointment Booked Alert to Patient.
     */
    public static function sendAppointmentBookedAlert(Appointment $appointment): void
    {
        if (GlobalSetting::get('sms_toggle_appointment_booked', '1') !== '1') return;

        $template = GlobalSetting::get(
            'sms_template_appointment_booked',
            'Dear {patient_name}, your appointment request with {doctor_name} has been received for {date}. Serial: {serial}. {hospital_name}'
        );

        $message = self::parseTemplate($template, [
            '{patient_name}'  => $appointment->name,
            '{doctor_name}'   => $appointment->doctor?->name ?? 'Doctor',
            '{date}'          => $appointment->appointment_date ? $appointment->appointment_date->format('d M Y') : 'TBD',
            '{time}'          => $appointment->time_slot ?? 'Regular Hours',
            '{serial}'        => $appointment->serial_number ? "#{$appointment->serial_number}" : 'Pending',
            '{amount}'        => number_format((float) $appointment->fee, 2),
            '{hospital_name}' => GlobalSetting::get('site_name', config('app.name')),
        ]);

        self::send($appointment->phone, $message, 'appointment_booked');
    }

    /**
     * Send Appointment Confirmed Alert.
     */
    public static function sendAppointmentConfirmedAlert(Appointment $appointment): void
    {
        if (GlobalSetting::get('sms_toggle_appointment_confirmed', '1') !== '1') return;

        $template = GlobalSetting::get(
            'sms_template_appointment_confirmed',
            'Dear {patient_name}, your appointment with {doctor_name} is CONFIRMED on {date} ({time}). Serial No: {serial}. {hospital_name}'
        );

        $message = self::parseTemplate($template, [
            '{patient_name}'  => $appointment->name,
            '{doctor_name}'   => $appointment->doctor?->name ?? 'Doctor',
            '{date}'          => $appointment->appointment_date ? $appointment->appointment_date->format('d M Y') : 'TBD',
            '{time}'          => $appointment->time_slot ?? 'Regular Hours',
            '{serial}'        => $appointment->serial_number ? "#{$appointment->serial_number}" : 'Pending',
            '{hospital_name}' => GlobalSetting::get('site_name', config('app.name')),
        ]);

        self::send($appointment->phone, $message, 'appointment_confirmed');
    }

    /**
     * Send Medical Test Booked Alert.
     */
    public static function sendMedicalTestBookedAlert(MedicalTestBooking $booking): void
    {
        if (GlobalSetting::get('sms_toggle_test_booked', '1') !== '1') return;

        $template = GlobalSetting::get(
            'sms_template_test_booked',
            'Dear {patient_name}, your medical test booking #{test_number} is received. Total: BDT {amount}, Paid: BDT {paid}, Due: BDT {due}. {hospital_name}'
        );

        $message = self::parseTemplate($template, [
            '{patient_name}'  => $booking->patient_name,
            '{test_number}'   => $booking->booking_number,
            '{amount}'        => number_format((float) $booking->total_amount, 2),
            '{paid}'          => number_format((float) $booking->paid_amount, 2),
            '{due}'           => number_format((float) $booking->due_amount, 2),
            '{hospital_name}' => GlobalSetting::get('site_name', config('app.name')),
        ]);

        self::send($booking->phone, $message, 'test_booked');
    }

    /**
     * Send Medical Test Completed / Results Ready Alert.
     */
    public static function sendMedicalTestCompletedAlert(MedicalTestBooking $booking): void
    {
        if (GlobalSetting::get('sms_toggle_test_completed', '1') !== '1') return;

        $template = GlobalSetting::get(
            'sms_template_test_completed',
            'Dear {patient_name}, diagnostic reports for booking #{test_number} are ready for collection at {hospital_name}. Thank you.'
        );

        $message = self::parseTemplate($template, [
            '{patient_name}'  => $booking->patient_name,
            '{test_number}'   => $booking->booking_number,
            '{hospital_name}' => GlobalSetting::get('site_name', config('app.name')),
        ]);

        self::send($booking->phone, $message, 'test_completed');
    }

    /**
     * Send Commission Credited Alert to Agent.
     */
    public static function sendCommissionAlert(AgentProfile $agent, float $amount, string $description): void
    {
        if (GlobalSetting::get('sms_toggle_commission_credited', '1') !== '1') return;

        $template = GlobalSetting::get(
            'sms_template_commission_credited',
            'Dear Agent {agent_name}, commission of BDT {amount} has been credited to your wallet. Available Balance: BDT {balance}. {hospital_name}'
        );

        $message = self::parseTemplate($template, [
            '{agent_name}'    => $agent->user?->name ?? 'Agent',
            '{amount}'        => number_format($amount, 2),
            '{balance}'       => number_format((float) $agent->wallet_balance, 2),
            '{hospital_name}' => GlobalSetting::get('site_name', config('app.name')),
        ]);

        $phone = $agent->phone ?? $agent->user?->phone;
        if ($phone) {
            self::send($phone, $message, 'commission_credited');
        }
    }

    /**
     * Send Withdrawal Status Alert to Agent.
     */
    public static function sendWithdrawalStatusAlert(AgentWithdrawal $withdrawal): void
    {
        if (GlobalSetting::get('sms_toggle_withdrawal_status', '1') !== '1') return;

        $statusText = strtoupper($withdrawal->status);
        $template = GlobalSetting::get(
            'sms_template_withdrawal_status',
            'Dear Agent, your cash out request #{withdrawal_number} for BDT {amount} is {status}. {txn_note} {hospital_name}'
        );

        $txnNote = $withdrawal->transaction_id ? "Txn ID: {$withdrawal->transaction_id}." : ($withdrawal->admin_notes ? "Note: {$withdrawal->admin_notes}." : '');

        $message = self::parseTemplate($template, [
            '{agent_name}'        => $withdrawal->agent?->user?->name ?? 'Agent',
            '{withdrawal_number}' => $withdrawal->withdrawal_number,
            '{amount}'            => number_format((float) $withdrawal->amount, 2),
            '{status}'            => $statusText,
            '{txn_note}'          => $txnNote,
            '{hospital_name}'     => GlobalSetting::get('site_name', config('app.name')),
        ]);

        $phone = $withdrawal->agent?->phone ?? $withdrawal->agent?->user?->phone;
        if ($phone) {
            self::send($phone, $message, 'withdrawal_status');
        }
    }

    /**
     * Replace template tokens.
     */
    public static function parseTemplate(string $template, array $data): string
    {
        return str_replace(array_keys($data), array_values($data), $template);
    }

    /**
     * Normalize Bangladesh phone number format.
     */
    public static function normalizeBdPhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone);
        if (str_starts_with($digits, '880')) {
            return $digits;
        }
        if (str_starts_with($digits, '01')) {
            return '88' . $digits;
        }
        return $digits;
    }
}
