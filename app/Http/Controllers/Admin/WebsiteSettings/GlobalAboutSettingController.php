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
        'about_exp_years',        // Experience badge value, e.g. "8+" (shown on Home page)
        'about_exp_label',        // Experience badge label, e.g. "Years Of Experience" (shown on Home page)
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
        'about_title', 'about_desc', 'about_page_desc', 'about_exp_label', 'about_hours_title', 'about_more_btn_text',
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
            'about_exp_years'     => 'nullable|string',
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

        $badgeVal = $request->input('about_exp_years');
        $data['about_exp_years'] = (is_string($badgeVal) && trim($badgeVal) !== '') ? trim($badgeVal) : null;

        if ($request->hasFile('about_photo')) {
            $existing = GlobalSetting::get('about_photo');
            if ($existing) {
                Storage::disk('public')->delete($existing);
            }
            $data['about_photo'] = $request->file('about_photo')->store('about', 'public');
        } else {
            unset($data['about_photo']);
        }

        // Explicitly handle about_hours so removing rows saves correctly
        $rawHours = $request->input('about_hours', []);
        $filteredHours = [];
        if (is_array($rawHours)) {
            foreach ($rawHours as $item) {
                $day = $item['day'] ?? null;
                $time = $item['time'] ?? null;
                $hasDay = is_array($day) ? !empty(array_filter($day, fn($v) => !empty(trim((string)$v)))) : !empty(trim((string)$day));
                $hasTime = is_array($time) ? !empty(array_filter($time, fn($v) => !empty(trim((string)$v)))) : !empty(trim((string)$time));
                if ($hasDay || $hasTime) {
                    $filteredHours[] = $item;
                }
            }
        }
        $data['about_hours'] = json_encode(array_values($filteredHours));

        // Explicitly handle about_features so removing features saves correctly
        $rawFeatures = $request->input('about_features', []);
        $filteredFeatures = [];
        if (is_array($rawFeatures)) {
            foreach ($rawFeatures as $f) {
                if (is_array($f)) {
                    if (!empty(array_filter($f, fn($v) => !empty(trim((string)$v))))) {
                        $filteredFeatures[] = $f;
                    }
                } elseif (!empty(trim((string)$f))) {
                    $filteredFeatures[] = $f;
                }
            }
        }
        $data['about_features'] = json_encode(array_values($filteredFeatures));

        GlobalSetting::setMany($data);

        return back()->with('success', 'About section settings saved.');
    }
}
