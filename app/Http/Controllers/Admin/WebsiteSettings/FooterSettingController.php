<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class FooterSettingController extends Controller
{
    private array $footerKeys = [
        'footer_logo',
        'footer_brand_description',
        'footer_facebook_url',
        'footer_twitter_url',
        'footer_instagram_url',
        'footer_youtube_url',
        'footer_quick_links',    // JSON array [{label, url}] — "Quick Links" column
        'footer_service_links',  // JSON array [{label, url}] — "Our Services" column
        'footer_store_links',    // JSON array [{label, url}] — "Our Stores" column
        'footer_useful_links',   // JSON array [{label, url}] — "Useful Links" column
        'footer_phone_1',
        'footer_phone_2',
        'footer_phone_3',
        'footer_email_1',
        'footer_email_2',
        'footer_address_line1',
        'footer_address_line2',
        'footer_website_url',
        'footer_opening_time',
        'footer_newsletter_title',
        'footer_privacy_url',
        'footer_terms_url',
        'footer_copyright_text',
    ];

    private array $jsonKeys = [
        'footer_quick_links',
        'footer_service_links',
        'footer_store_links',
        'footer_useful_links',
    ];

    /** Plain human-copy keys edited per-locale. Link-group item `label`s are handled separately below (nested). */
    private array $translatableKeys = [
        'footer_brand_description', 'footer_opening_time', 'footer_newsletter_title', 'footer_copyright_text',
        'footer_phone_1', 'footer_phone_2', 'footer_phone_3', 'footer_address_line1', 'footer_address_line2',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->footerKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->footerKeys as $key) {
            $settings[$key] ??= null;
        }

        foreach ($this->translatableKeys as $key) {
            $settings[$key] = GlobalSetting::getTranslatedArray($key);
        }

        // Decode JSON link-group fields — each item's `label` becomes {en,bn}
        foreach ($this->jsonKeys as $jsonKey) {
            $items = !empty($settings[$jsonKey]) ? json_decode($settings[$jsonKey], true) : [];
            $settings[$jsonKey] = collect($items)->map(function ($item) {
                $item['label'] = is_array($item['label'] ?? null) ? $item['label'] : ['en' => $item['label'] ?? '', 'bn' => ''];
                return $item;
            })->values()->all();
        }

        return Inertia::render('Admin/WebsiteSettings/Footer/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $linkRules = [];
        foreach ($this->jsonKeys as $jsonKey) {
            $linkRules[$jsonKey]                  = 'nullable|array';
            $linkRules["$jsonKey.*.label"]         = 'required|array';
            $linkRules["$jsonKey.*.label.*"]       = 'nullable|string';
            $linkRules["$jsonKey.*.url"]           = 'required|string';
        }

        $rules = [
            'footer_logo'              => 'nullable|image|mimes:jpeg,jpg,png,webp,svg',
            'footer_facebook_url'      => 'nullable|string',
            'footer_twitter_url'       => 'nullable|string',
            'footer_instagram_url'     => 'nullable|string',
            'footer_youtube_url'       => 'nullable|string',
            'footer_email_1'           => 'nullable|email',
            'footer_email_2'           => 'nullable|email',
            'footer_website_url'       => 'nullable|string',
            'footer_privacy_url'       => 'nullable|string',
            'footer_terms_url'         => 'nullable|string',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate(array_merge($rules, $linkRules));

        if ($request->hasFile('footer_logo')) {
            $existing = GlobalSetting::get('footer_logo');
            if ($existing) {
                Storage::disk('public')->delete($existing);
            }
            $data['footer_logo'] = $request->file('footer_logo')
                ->store('settings', 'public');
        } else {
            unset($data['footer_logo']);
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        // Encode JSON fields before saving
        foreach ($this->jsonKeys as $jsonKey) {
            if (isset($data[$jsonKey])) {
                $data[$jsonKey] = json_encode($data[$jsonKey], JSON_UNESCAPED_UNICODE);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Footer settings saved.');
    }
}
