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

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->footerKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->footerKeys as $key) {
            $settings[$key] ??= null;
        }

        // Decode JSON fields
        foreach ($this->jsonKeys as $jsonKey) {
            $settings[$jsonKey] = !empty($settings[$jsonKey])
                ? json_decode($settings[$jsonKey], true)
                : [];
        }

        return Inertia::render('Admin/WebsiteSettings/Footer/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $linkRules = [];
        foreach ($this->jsonKeys as $jsonKey) {
            $linkRules[$jsonKey]                = 'nullable|array';
            $linkRules["$jsonKey.*.label"] = 'required|string';
            $linkRules["$jsonKey.*.url"]   = 'required|string';
        }

        $data = $request->validate(array_merge([
            'footer_logo'              => 'nullable|image|mimes:jpeg,jpg,png,webp,svg',
            'footer_brand_description' => 'nullable|string',
            'footer_facebook_url'      => 'nullable|string',
            'footer_twitter_url'       => 'nullable|string',
            'footer_instagram_url'     => 'nullable|string',
            'footer_youtube_url'       => 'nullable|string',
            'footer_phone_1'           => 'nullable|string',
            'footer_phone_2'           => 'nullable|string',
            'footer_phone_3'           => 'nullable|string',
            'footer_email_1'           => 'nullable|email',
            'footer_email_2'           => 'nullable|email',
            'footer_address_line1'     => 'nullable|string',
            'footer_address_line2'     => 'nullable|string',
            'footer_website_url'       => 'nullable|string',
            'footer_opening_time'      => 'nullable|string',
            'footer_newsletter_title'  => 'nullable|string',
            'footer_privacy_url'       => 'nullable|string',
            'footer_terms_url'         => 'nullable|string',
            'footer_copyright_text'    => 'nullable|string',
        ], $linkRules));

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

        // Encode JSON fields before saving
        foreach ($this->jsonKeys as $jsonKey) {
            if (isset($data[$jsonKey])) {
                $data[$jsonKey] = json_encode($data[$jsonKey]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Footer settings saved.');
    }
}
