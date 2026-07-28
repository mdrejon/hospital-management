<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogSettingController extends Controller
{
    private array $keys = [
        'blog_home_title',
        'blog_hero_image',
        'blog_hero_title',
        'blog_seo_title',
        'blog_seo_description',
        'blog_seo_keywords',
        'blog_seo_og_image',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. Everything else in $keys stays a plain value. */
    private array $translatableKeys = [
        'blog_home_title', 'blog_hero_title', 'blog_seo_title', 'blog_seo_description',
    ];

    /** Used by Admin\BlogController::index() to feed the "Page Settings" tab. */
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
            'blog_seo_keywords'    => 'nullable|string',
            'blog_hero_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'blog_seo_og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach (['blog_hero_image', 'blog_seo_og_image'] as $imgKey) {
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

        if (empty($data['blog_seo_keywords'])) {
            $data['blog_seo_keywords'] = $this->autoKeywords(
                $data['blog_seo_title']['en'] ?? GlobalSetting::getTranslated('blog_seo_title', 'en', ''),
                $data['blog_seo_description']['en'] ?? GlobalSetting::getTranslated('blog_seo_description', 'en', '')
            );
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Blog page settings saved.');
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
