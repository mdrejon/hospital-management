<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class GlobalAboutSettingController extends Controller
{
    /** About Section — shared: shown on Home page and About page. */
    private array $aboutKeys = [
        'about_photo',
        'about_title',
        'about_desc',
        'about_page_desc',        // rich HTML — About page only; overrides about_desc there when filled
        'about_hours_title',
        'about_hours',            // JSON array [{day, time}]
        'about_features',         // JSON array of strings
        'about_more_btn_text',
        'about_more_btn_url',
    ];

    /** JSON-encoded keys that hold arrays */
    private array $jsonKeys = [
        'about_hours',
        'about_features',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. Everything else in $aboutKeys stays a plain value. */
    private array $translatableKeys = [
        'about_title', 'about_desc', 'about_page_desc', 'about_hours_title', 'about_more_btn_text',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->aboutKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->aboutKeys as $key) {
            $settings[$key] ??= null;
        }

        foreach ($this->translatableKeys as $key) {
            $settings[$key] = GlobalSetting::getTranslatedArray($key);
        }

        foreach ($this->jsonKeys as $key) {
            $settings[$key] = $settings[$key]
                ? json_decode($settings[$key], true)
                : [];
        }

        // Reshape JSON-array items — genuinely textual sub-fields become {en,bn}.
        // (day/time-of-week values here are free-text display copy, not structural keys.)
        $toTranslatable = fn ($value) => is_array($value) ? $value : ['en' => $value ?? '', 'bn' => ''];

        $settings['about_hours'] = collect($settings['about_hours'])->map(function ($item) use ($toTranslatable) {
            $item['day']  = $toTranslatable($item['day'] ?? null);
            $item['time'] = $toTranslatable($item['time'] ?? null);
            return $item;
        })->values()->all();

        $settings['about_features'] = collect($settings['about_features'])
            ->map(fn ($item) => $toTranslatable($item))
            ->values()->all();

        return Inertia::render('Admin/WebsiteSettings/GlobalAbout/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'about_photo'         => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'about_hours'         => 'nullable|array',
            'about_hours.*.day'   => 'nullable|array',
            'about_hours.*.day.*' => 'nullable|string',
            'about_hours.*.time'  => 'nullable|array',
            'about_hours.*.time.*' => 'nullable|string',
            'about_features'      => 'nullable|array',
            'about_features.*'    => 'nullable|array',
            'about_features.*.*'  => 'nullable|string',
            'about_more_btn_url'  => 'nullable|string',
        ];

        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        if ($request->hasFile('about_photo')) {
            $existing = GlobalSetting::get('about_photo');
            if ($existing) {
                Storage::disk('public')->delete($existing);
            }
            $data['about_photo'] = $request->file('about_photo')->store('about', 'public');
        } else {
            unset($data['about_photo']);
        }

        // Encode array fields as JSON
        foreach ($this->jsonKeys as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                $data[$key] = json_encode(array_values($data[$key]));
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'About section settings saved.');
    }
}
