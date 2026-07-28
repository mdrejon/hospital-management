<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceSettingController extends Controller
{
    private array $keys = [
        // Page hero / breadcrumb
        'svc_page_hero_image',
        'svc_page_hero_title',
        // SEO
        'svc_seo_title',
        'svc_seo_description',
        'svc_seo_keywords',
        'svc_seo_og_image',
        // Homepage section
        'svc_badge',
        'svc_title',
        'svc_desc',
        'svc_btn_text',
        'svc_btn_url',
        // Detail page sidebar "Needs Any Help?" box
        'svc_help_title',
        'svc_help_desc',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. Everything else in $keys stays a plain value. */
    private array $translatableKeys = [
        'svc_badge', 'svc_title', 'svc_desc', 'svc_btn_text',
        'svc_page_hero_title', 'svc_help_title', 'svc_help_desc',
        'svc_seo_title', 'svc_seo_description',
    ];

    /** Used by Admin\ServiceController::index() to feed the "Page Settings" tab. */
    public function currentSettings(): array
    {
        $settings = GlobalSetting::whereIn('key', $this->keys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->keys as $key) {
            $settings[$key] ??= null;
        }

        foreach ($this->translatableKeys as $key) {
            $settings[$key] = GlobalSetting::getTranslatedArray($key);
        }

        return $settings;
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            // Hero / breadcrumb
            'svc_page_hero_image'   => 'nullable|image|mimes:jpeg,jpg,png,webp',
            // SEO
            'svc_seo_keywords'      => 'nullable|string',
            'svc_seo_og_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
            // Homepage section
            'svc_btn_url'           => 'nullable|string',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach (['svc_page_hero_image', 'svc_seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $existing = GlobalSetting::get($field);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$field] = $request->file($field)->store('services-settings', 'public');
            } else {
                unset($data[$field]);
            }
        }

        // Auto-generate keywords if none provided (svc_seo_title/description are {en,bn} arrays)
        if (empty($data['svc_seo_keywords'])) {
            $titleText = $data['svc_seo_title'] ?? GlobalSetting::getTranslatedArray('svc_seo_title');
            $descText  = $data['svc_seo_description'] ?? GlobalSetting::getTranslatedArray('svc_seo_description');
            $data['svc_seo_keywords'] = $this->autoKeywords(
                is_array($titleText) ? implode(' ', $titleText) : $titleText,
                is_array($descText) ? implode(' ', $descText) : $descText
            );
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Services settings saved.');
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
