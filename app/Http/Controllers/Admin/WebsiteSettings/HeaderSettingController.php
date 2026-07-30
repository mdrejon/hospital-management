<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HeaderSettingController extends Controller
{
    private array $headerKeys = [
        'header_logo',
        'header_favicon',
        'header_site_name',
        'header_tagline',
        'header_phone',
        'header_email',
        'header_address',
        'header_hours',
        'header_support_text',
        'header_sidebar_description',
        'header_facebook_url',
        'header_twitter_url',
        'header_instagram_url',
        'header_linkedin_url',
        'header_book_btn_text',
        'header_book_btn_url',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. Everything else in $headerKeys stays a plain value. */
    private array $translatableKeys = [
        'header_tagline', 'header_hours', 'header_support_text',
        'header_sidebar_description', 'header_book_btn_text', 'header_address', 'header_phone',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->headerKeys)
            ->pluck('value', 'key')
            ->toArray();

        // Fill missing keys with null so Vue always has all fields
        foreach ($this->headerKeys as $key) {
            $settings[$key] ??= null;
        }

        foreach ($this->translatableKeys as $key) {
            $settings[$key] = GlobalSetting::getTranslatedArray($key);
        }

        return Inertia::render('Admin/WebsiteSettings/Header/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'header_site_name'            => 'nullable|string',
            'header_email'                => 'nullable|email',
            'header_facebook_url'         => 'nullable|string',
            'header_twitter_url'          => 'nullable|string',
            'header_instagram_url'        => 'nullable|string',
            'header_linkedin_url'         => 'nullable|string',
            'header_book_btn_url'         => 'nullable|string',
            'header_logo'                 => 'nullable|image|mimes:jpeg,jpg,png,webp,svg',
            // Not `image` — Laravel's image rule doesn't recognize .ico, which is a common favicon format.
            'header_favicon'              => 'nullable|file|mimes:ico,png,jpg,jpeg,webp,svg|max:512',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('header_logo')) {
            $existing = GlobalSetting::get('header_logo');
            if ($existing) {
                Storage::disk('public')->delete($existing);
            }
            $data['header_logo'] = $request->file('header_logo')
                ->store('settings', 'public');
        } else {
            unset($data['header_logo']);
        }

        if ($request->hasFile('header_favicon')) {
            $existing = GlobalSetting::get('header_favicon');
            if ($existing) {
                Storage::disk('public')->delete($existing);
            }
            $data['header_favicon'] = $request->file('header_favicon')
                ->store('settings', 'public');
        } else {
            unset($data['header_favicon']);
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Header settings saved.');
    }
}
