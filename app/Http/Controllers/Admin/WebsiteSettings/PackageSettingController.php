<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\Language;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageSettingController extends Controller
{
    private array $keys = [
        // Page hero / breadcrumb
        'pkg_page_hero_image',
        'pkg_page_hero_title',
        // SEO
        'pkg_seo_title',
        'pkg_seo_description',
        'pkg_seo_keywords',
        'pkg_seo_og_image',
        // Homepage section
        'pkg_badge',
        'pkg_title',
        'pkg_desc',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. */
    private array $translatableKeys = [
        'pkg_page_hero_title', 'pkg_seo_title', 'pkg_seo_description',
        'pkg_badge', 'pkg_title', 'pkg_desc',
    ];

    /** Used by Admin\PackageController::index() to feed the "Page Settings" tab. */
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
        $default = Language::defaultLanguage()?->code ?? config('app.locale');

        $rules = [
            'pkg_page_hero_image'   => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'pkg_seo_keywords'      => 'nullable|string',
            'pkg_seo_og_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach (['pkg_page_hero_image', 'pkg_seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $existing = GlobalSetting::get($field);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$field] = $request->file($field)->store('packages-settings', 'public');
            } else {
                unset($data[$field]);
            }
        }

        if (empty($data['pkg_seo_keywords'])) {
            $data['pkg_seo_keywords'] = $this->autoKeywords(
                $data['pkg_seo_title'][$default] ?? GlobalSetting::getTranslated('pkg_seo_title', $default, ''),
                $data['pkg_seo_description'][$default] ?? GlobalSetting::getTranslated('pkg_seo_description', $default, '')
            );
        }

        foreach ($this->translatableKeys as $key) {
            if (array_key_exists($key, $data)) {
                GlobalSetting::setTranslated($key, $data[$key] ?? []);
                unset($data[$key]);
            }
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Packages settings saved.');
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
