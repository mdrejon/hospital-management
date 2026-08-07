<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\SmsLog;
use App\Services\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SmsSettingController extends Controller
{
    private array $defaultSettings = [
        'sms_enabled'                        => '0',
        'sms_provider'                       => 'generic_http', // generic_http, ssl_wireless, greenweb, bulksms_bd
        'sms_api_url'                        => '',
        'sms_api_key'                        => '',
        'sms_sender_id'                      => 'HOSPITAL',
        'sms_client_id'                      => '',
        'sms_method'                         => 'GET',

        // Toggles & Templates
        'sms_toggle_appointment_booked'      => '1',
        'sms_template_appointment_booked'    => 'Dear {patient_name}, your appointment request with {doctor_name} has been received for {date}. Serial: {serial}. {hospital_name}',

        'sms_toggle_appointment_confirmed'   => '1',
        'sms_template_appointment_confirmed' => 'Dear {patient_name}, your appointment with {doctor_name} is CONFIRMED on {date} ({time}). Serial No: {serial}. {hospital_name}',

        'sms_toggle_test_booked'             => '1',
        'sms_template_test_booked'           => 'Dear {patient_name}, your medical test booking #{test_number} is received. Total: BDT {amount}, Paid: BDT {paid}, Due: BDT {due}. {hospital_name}',

        'sms_toggle_test_completed'          => '1',
        'sms_template_test_completed'        => 'Dear {patient_name}, diagnostic reports for booking #{test_number} are ready for collection at {hospital_name}. Thank you.',

        'sms_toggle_commission_credited'     => '1',
        'sms_template_commission_credited'   => 'Dear Agent {agent_name}, commission of BDT {amount} has been credited to your wallet. Available Balance: BDT {balance}. {hospital_name}',

        'sms_toggle_withdrawal_status'       => '1',
        'sms_template_withdrawal_status'     => 'Dear Agent, your cash out request #{withdrawal_number} for BDT {amount} is {status}. {txn_note} {hospital_name}',
    ];

    public function edit(): Response
    {
        $settings = [];
        foreach ($this->defaultSettings as $key => $default) {
            $settings[$key] = GlobalSetting::get($key, $default);
        }

        $logs = SmsLog::latest()->take(30)->get();

        return Inertia::render('Admin/WebsiteSettings/Sms/Edit', [
            'settings' => $settings,
            'recentLogs' => $logs,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sms_enabled'                        => ['required', 'in:0,1'],
            'sms_provider'                       => ['required', 'string', 'max:50'],
            'sms_api_url'                        => ['nullable', 'string', 'max:500'],
            'sms_api_key'                        => ['nullable', 'string', 'max:255'],
            'sms_sender_id'                      => ['nullable', 'string', 'max:50'],
            'sms_client_id'                      => ['nullable', 'string', 'max:50'],
            'sms_method'                         => ['required', 'in:GET,POST'],
            'sms_toggle_appointment_booked'      => ['nullable', 'in:0,1'],
            'sms_template_appointment_booked'    => ['required', 'string', 'max:500'],
            'sms_toggle_appointment_confirmed'   => ['nullable', 'in:0,1'],
            'sms_template_appointment_confirmed' => ['required', 'string', 'max:500'],
            'sms_toggle_test_booked'             => ['nullable', 'in:0,1'],
            'sms_template_test_booked'           => ['required', 'string', 'max:500'],
            'sms_toggle_test_completed'          => ['nullable', 'in:0,1'],
            'sms_template_test_completed'        => ['required', 'string', 'max:500'],
            'sms_toggle_commission_credited'     => ['nullable', 'in:0,1'],
            'sms_template_commission_credited'   => ['required', 'string', 'max:500'],
            'sms_toggle_withdrawal_status'       => ['nullable', 'in:0,1'],
            'sms_template_withdrawal_status'     => ['required', 'string', 'max:500'],
        ]);

        GlobalSetting::setMany($validated);

        return back()->with('success', 'SMS gateway settings and templates updated successfully.');
    }

    public function testSms(Request $request): RedirectResponse
    {
        $request->validate([
            'test_phone'   => ['required', 'string', 'max:30'],
            'test_message' => ['required', 'string', 'max:300'],
        ]);

        $res = SmsService::send($request->input('test_phone'), $request->input('test_message'), 'test_sms');

        if ($res['success']) {
            $msg = ($res['simulated'] ?? false) ? 'Test SMS simulated & logged successfully.' : 'Test SMS dispatched successfully!';
            return back()->with('success', $msg);
        }

        return back()->with('error', 'Failed sending SMS: ' . ($res['error'] ?? 'Gateway returned non-200 code'));
    }

    public function logs(Request $request): Response
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $logs = SmsLog::when($search, function ($q, $search) {
                $q->where('recipient_phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            })
            ->when($status, function ($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/WebsiteSettings/Sms/Logs', [
            'logs'    => $logs,
            'filters' => [
                'search' => $search,
                'status' => $status,
            ],
        ]);
    }
}
