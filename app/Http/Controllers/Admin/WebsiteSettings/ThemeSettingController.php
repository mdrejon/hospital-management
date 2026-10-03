<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThemeSettingController extends Controller
{
    public function edit()
    {
        $settings = GlobalSetting::whereIn('key', [
            'theme_color_primary',
            'theme_color_secondary',
            'theme_color_navy',
            'theme_color_navy_dark',
            'theme_color_accent_green',
            'theme_color_accent_red',
        ])->pluck('value', 'key')->toArray();

        return Inertia::render('Admin/WebsiteSettings/Theme/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme_color_primary' => 'nullable|string|max:7',
            'theme_color_secondary' => 'nullable|string|max:7',
            'theme_color_navy' => 'nullable|string|max:7',
            'theme_color_navy_dark' => 'nullable|string|max:7',
            'theme_color_accent_green' => 'nullable|string|max:7',
            'theme_color_accent_red' => 'nullable|string|max:7',
        ]);

        foreach ($validated as $key => $value) {
            GlobalSetting::set($key, $value);
        }

        return back()->with('success', 'Theme settings updated successfully.');
    }

    public function reset()
    {
        GlobalSetting::whereIn('key', [
            'theme_color_primary',
            'theme_color_secondary',
            'theme_color_navy',
            'theme_color_navy_dark',
            'theme_color_accent_green',
            'theme_color_accent_red',
        ])->delete();

        return back()->with('success', 'Theme settings reset to defaults.');
    }
}
