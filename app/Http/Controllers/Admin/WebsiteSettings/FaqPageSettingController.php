<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\Language;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class FaqPageSettingController extends Controller
{
    private array $keys = [
        'faq_hero_image',
        'faq_hero_title',
        'faq_seo_title',
        'faq_seo_description',
        'faq_seo_keywords',
        'faq_seo_og_image',
        'faq_page_badge',
        'faq_page_title',
        'faq_page_desc',
        'faq_page_image',
    ];

    /** Human-copy keys edited per-locale. */
    private array $translatableKeys = [
        'faq_hero_title', 'faq_seo_title', 'faq_seo_description',
        'faq_page_badge', 'faq_page_title', 'faq_page_desc',
    ];

    public function edit(): Response
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

        return Inertia::render('Admin/WebsiteSettings/Faq/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $rules = [
            'faq_seo_keywords'    => 'nullable|string',
            'faq_hero_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'faq_seo_og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'faq_page_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach (['faq_hero_image', 'faq_seo_og_image', 'faq_page_image'] as $imgKey) {
            if ($request->hasFile($imgKey)) {
                $existing = GlobalSetting::get($imgKey);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$imgKey] = $request->file($imgKey)->store('settings', 'public');
            } else {
                unset($data[$imgKey]);
            }
        }

        // Auto-generate keywords if none provided
        if (empty($data['faq_seo_keywords'])) {
            $data['faq_seo_keywords'] = $this->autoKeywords(
                $data['faq_seo_title'][$default] ?? GlobalSetting::getTranslated('faq_seo_title', $default, ''),
                $data['faq_seo_description'][$default] ?? GlobalSetting::getTranslated('faq_seo_description', $default, '')
            );
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'FAQ page settings saved.');
    }

    private function autoKeywords(string|null ...$texts): string
    {
        static $stop = [
            'a','an','the','and','or','but','in','on','at','to','for','of','with',
            'by','from','as','is','was','are','were','be','been','being','have',
            'has','had','do','does','did','will','would','could','should','may',
            'might','can','this','that','these','those','it','its','we','our',
            'you','your','hotel','beach','way','cox','bazar',
        ];
        $text  = implode(' ', array_filter($texts, fn($t) => $t !== null));
        $words = preg_split('/\W+/u', mb_strtolower($text), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_filter($words, fn($w) => mb_strlen($w) > 3 && !in_array($w, $stop, true));
        return implode(', ', array_slice(array_unique(array_values($words)), 0, 12));
    }
}
