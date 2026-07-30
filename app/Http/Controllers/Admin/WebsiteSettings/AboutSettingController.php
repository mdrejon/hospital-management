<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AboutSettingController extends Controller
{
    private array $aboutKeys = [
        // Page hero / breadcrumb (about page)
        'about_hero_image',
        'about_hero_title',
        // SEO (about page)
        'about_seo_title',
        'about_seo_description',
        'about_seo_keywords',
        'about_seo_og_image',
        // Mission & Vision section (about page)
        'about_mv_title',
        'about_mv_desc',
        'about_mv_image',
        'about_mv_cards',         // JSON array [{title, description}]
        // CEO Message section (about page)
        'ceo_image',
        'ceo_badge_value',
        'ceo_badge_label',
        'ceo_eyebrow',
        'ceo_title',
        'ceo_message',
        'ceo_focus_label',
        'ceo_focus_items',        // JSON array of strings
        'ceo_awards',             // JSON array [{year, org, label}]
    ];

    /** JSON-encoded keys that hold arrays */
    private array $jsonKeys = [
        'about_mv_cards',
        'ceo_focus_items',
        'ceo_awards',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. Everything else in $aboutKeys stays a plain value. */
    private array $translatableKeys = [
        'about_hero_title', 'about_seo_title', 'about_seo_description',
        'about_mv_title', 'about_mv_desc',
        'ceo_badge_label', 'ceo_eyebrow', 'ceo_title', 'ceo_message', 'ceo_focus_label',
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

        $settings['about_mv_cards'] = collect($settings['about_mv_cards'])->map(function ($item) use ($toTranslatable) {
            $item['title']       = $toTranslatable($item['title'] ?? null);
            $item['description'] = $toTranslatable($item['description'] ?? null);
            return $item;
        })->values()->all();

        $settings['ceo_focus_items'] = collect($settings['ceo_focus_items'])
            ->map(fn ($item) => $toTranslatable($item))
            ->values()->all();

        // year/org are structural identifiers (award year, issuing org name) — left plain; label is the descriptive copy.
        $settings['ceo_awards'] = collect($settings['ceo_awards'])->map(function ($item) use ($toTranslatable) {
            $item['label'] = $toTranslatable($item['label'] ?? null);
            return $item;
        })->values()->all();

        return Inertia::render('Admin/WebsiteSettings/About/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'about_hero_image'          => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'about_seo_keywords'        => 'nullable|string',
            'about_seo_og_image'        => 'nullable|image|mimes:jpeg,jpg,png,webp',

            'about_mv_image'             => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'about_mv_cards'             => 'nullable|array',
            'about_mv_cards.*.title'       => 'nullable|array',
            'about_mv_cards.*.title.*'     => 'nullable|string',
            'about_mv_cards.*.description' => 'nullable|array',
            'about_mv_cards.*.description.*' => 'nullable|string',

            'ceo_image'                  => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'ceo_badge_value'            => 'nullable|string',
            'ceo_focus_items'            => 'nullable|array',
            'ceo_focus_items.*'          => 'nullable|array',
            'ceo_focus_items.*.*'        => 'nullable|string',
            'ceo_awards'                 => 'nullable|array',
            'ceo_awards.*.year'          => 'nullable|string',
            'ceo_awards.*.org'           => 'nullable|string',
            'ceo_awards.*.label'         => 'nullable|array',
            'ceo_awards.*.label.*'       => 'nullable|string',
        ];

        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        // Handle image uploads
        foreach (['about_hero_image', 'about_seo_og_image', 'about_mv_image', 'ceo_image'] as $field) {
            if ($request->hasFile($field)) {
                $existing = GlobalSetting::get($field);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$field] = $request->file($field)->store('about', 'public');
            } else {
                unset($data[$field]);
            }
        }

        // Auto-generate keywords if none provided (title/description are {en,bn} arrays)
        if (empty($data['about_seo_keywords'])) {
            $titleText = $data['about_seo_title'] ?? GlobalSetting::getTranslatedArray('about_seo_title');
            $descText  = $data['about_seo_description'] ?? GlobalSetting::getTranslatedArray('about_seo_description');
            $data['about_seo_keywords'] = $this->autoKeywords(
                is_array($titleText) ? implode(' ', $titleText) : $titleText,
                is_array($descText) ? implode(' ', $descText) : $descText
            );
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

    private function autoKeywords(string|null ...$texts): string
    {
        static $stop = [
            'a','an','the','and','or','but','in','on','at','to','for','of','with',
            'by','from','as','is','was','are','were','be','been','being','have',
            'has','had','do','does','did','will','would','could','should','may',
            'might','can','this','that','these','those','it','its','we','our',
            'you','your',
        ];
        $text  = implode(' ', array_filter($texts, fn($t) => $t !== null));
        $words = preg_split('/\W+/u', mb_strtolower($text), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_filter($words, fn($w) => mb_strlen($w) > 3 && !in_array($w, $stop, true));
        return implode(', ', array_slice(array_unique(array_values($words)), 0, 12));
    }
}
