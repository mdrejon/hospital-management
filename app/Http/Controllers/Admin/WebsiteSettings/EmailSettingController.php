<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailSettingController extends Controller
{
    private array $toggleDefaults = [
        'email_toggle_new_inquiry_customer' => true,
        'email_toggle_new_inquiry_admin'    => true,
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', array_keys($this->toggleDefaults))
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->toggleDefaults as $key => $default) {
            $settings[$key] = array_key_exists($key, $settings) ? $settings[$key] === '1' : $default;
        }

        return Inertia::render('Admin/WebsiteSettings/Email/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];
        foreach (array_keys($this->toggleDefaults) as $key) {
            $rules[$key] = 'boolean';
        }

        $request->validate($rules);

        $data = [];
        foreach ($this->toggleDefaults as $key => $default) {
            $data[$key] = $request->boolean($key) ? '1' : '0';
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Email notification settings saved.');
    }
}
