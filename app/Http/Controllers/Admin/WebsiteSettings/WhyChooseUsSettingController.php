<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class WhyChooseUsSettingController extends Controller
{
    /** Why Choose Us section — shown on Home page. */
    private array $whyKeys = [
        'why_photo',
        'why_bg_photo',
        'why_badge',
        'why_title',
        'why_desc',
        'why_badge_number',
        'why_badge_label',
        'why_features',           // JSON array [{title, description}]
    ];

    /** JSON-encoded keys that hold arrays */
    private array $jsonKeys = [
        'why_features',
    ];

    /** Uploaded images — stored as a plain path string. */
    private array $imageKeys = [
        'why_photo',
        'why_bg_photo',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. Everything else in $whyKeys stays a plain value. */
    private array $translatableKeys = [
        'why_badge', 'why_title', 'why_desc', 'why_badge_number', 'why_badge_label',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->whyKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->whyKeys as $key) {
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

        // Cards carry title/description only — the tick icon is fixed by the design.
        $toTranslatable = fn ($value) => is_array($value) ? $value : ['en' => $value ?? '', 'bn' => ''];
        $settings['why_features'] = collect($settings['why_features'])->map(fn ($item) => [
            'title'       => $toTranslatable($item['title'] ?? null),
            'description' => $toTranslatable($item['description'] ?? null),
        ])->values()->all();

        return Inertia::render('Admin/WebsiteSettings/WhyChooseUs/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'why_photo'                    => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'why_bg_photo'                 => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'why_features'                 => 'nullable|array',
            'why_features.*.title'         => 'nullable|array',
            'why_features.*.title.*'       => 'nullable|string',
            'why_features.*.description'   => 'nullable|array',
            'why_features.*.description.*' => 'nullable|string',
        ];

        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach ($this->imageKeys as $imgKey) {
            if ($request->hasFile($imgKey)) {
                $existing = GlobalSetting::get($imgKey);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$imgKey] = $request->file($imgKey)->store('why-choose', 'public');
            } else {
                unset($data[$imgKey]);
            }
        }

        // Drop any sub-key the form no longer sends (e.g. the retired icon_svg).
        if (isset($data['why_features'])) {
            $data['why_features'] = collect($data['why_features'])->map(fn ($item) => [
                'title'       => $item['title'] ?? [],
                'description' => $item['description'] ?? [],
            ])->values()->all();
        }

        foreach ($this->jsonKeys as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                $data[$key] = json_encode(array_values($data[$key]), JSON_UNESCAPED_UNICODE);
            }
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Why Choose Us settings saved.');
    }
}
