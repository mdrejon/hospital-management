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
        // About section (shared: home page + about page)
        'about_photo',
        'about_title',
        'about_desc',
        'about_hours_title',
        'about_hours',            // JSON array [{day, time}]
        'about_features',         // JSON array of strings
        'about_more_btn_text',
        'about_more_btn_url',
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
        // Why Choose Us section (home page)
        'why_badge',
        'why_title',
        'why_desc',
        'why_features',           // JSON array [{icon_svg, title, description}]
    ];

    /** JSON-encoded keys that hold arrays */
    private array $jsonKeys = [
        'about_hours',
        'about_features',
        'about_mv_cards',
        'ceo_focus_items',
        'ceo_awards',
        'why_features',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->aboutKeys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->aboutKeys as $key) {
            $settings[$key] ??= null;
        }

        foreach ($this->jsonKeys as $key) {
            $settings[$key] = $settings[$key]
                ? json_decode($settings[$key], true)
                : [];
        }

        return Inertia::render('Admin/WebsiteSettings/About/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'about_hero_image'          => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'about_hero_title'          => 'nullable|string',
            'about_seo_title'           => 'nullable|string',
            'about_seo_description'     => 'nullable|string',
            'about_seo_keywords'        => 'nullable|string',
            'about_seo_og_image'        => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'about_photo'               => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'about_title'                => 'nullable|string',
            'about_desc'                 => 'nullable|string',
            'about_hours_title'          => 'nullable|string',
            'about_hours'                => 'nullable|array',
            'about_hours.*.day'          => 'nullable|string',
            'about_hours.*.time'         => 'nullable|string',
            'about_features'             => 'nullable|array',
            'about_features.*'           => 'nullable|string',
            'about_more_btn_text'        => 'nullable|string',
            'about_more_btn_url'         => 'nullable|string',

            'about_mv_title'             => 'nullable|string',
            'about_mv_desc'              => 'nullable|string',
            'about_mv_image'             => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'about_mv_cards'             => 'nullable|array',
            'about_mv_cards.*.title'       => 'nullable|string',
            'about_mv_cards.*.description' => 'nullable|string',

            'ceo_image'                  => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'ceo_badge_value'            => 'nullable|string',
            'ceo_badge_label'            => 'nullable|string',
            'ceo_eyebrow'                => 'nullable|string',
            'ceo_title'                  => 'nullable|string',
            'ceo_message'                => 'nullable|string',
            'ceo_focus_label'            => 'nullable|string',
            'ceo_focus_items'            => 'nullable|array',
            'ceo_focus_items.*'          => 'nullable|string',
            'ceo_awards'                 => 'nullable|array',
            'ceo_awards.*.year'          => 'nullable|string',
            'ceo_awards.*.org'           => 'nullable|string',
            'ceo_awards.*.label'         => 'nullable|string',

            'why_badge'                  => 'nullable|string',
            'why_title'                  => 'nullable|string',
            'why_desc'                   => 'nullable|string',
            'why_features'               => 'nullable|array',
            'why_features.*.icon_svg'    => 'nullable|string',
            'why_features.*.title'       => 'nullable|string',
            'why_features.*.description' => 'nullable|string',
        ]);

        // Handle image uploads
        foreach (['about_hero_image', 'about_seo_og_image', 'about_photo', 'about_mv_image', 'ceo_image'] as $field) {
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

        // Auto-generate keywords if none provided
        if (empty($data['about_seo_keywords'])) {
            $data['about_seo_keywords'] = $this->autoKeywords(
                $data['about_seo_title'] ?? GlobalSetting::get('about_seo_title', ''),
                $data['about_seo_description'] ?? GlobalSetting::get('about_seo_description', ''),
                $data['about_title'] ?? GlobalSetting::get('about_title', '')
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
