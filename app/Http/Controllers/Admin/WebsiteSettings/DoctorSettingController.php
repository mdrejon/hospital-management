<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorSettingController extends Controller
{
    private array $keys = [
        // Home page "Meet Our Doctor" section
        'doc_home_badge',
        'doc_home_title',
        // List page hero / breadcrumb
        'doc_page_hero_image',
        'doc_page_hero_title',
        // List page section head
        'doc_badge',
        'doc_title',
        // SEO
        'doc_seo_title',
        'doc_seo_description',
        'doc_seo_keywords',
        'doc_seo_og_image',
    ];

    /** Human-readable copy shown to visitors — edited per-locale. Everything else in $keys stays a plain value. */
    private array $translatableKeys = [
        'doc_home_badge', 'doc_home_title', 'doc_page_hero_title',
        'doc_badge', 'doc_title', 'doc_seo_title', 'doc_seo_description',
    ];

    /** Used by Admin\DoctorController::index() to feed the "Page Settings" tab. */
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
            'doc_page_hero_image'   => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'doc_seo_keywords'      => 'nullable|string',
            'doc_seo_og_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ];
        foreach ($this->translatableKeys as $key) {
            $rules[$key] = 'nullable|array';
            $rules["$key.*"] = 'nullable|string';
        }

        $data = $request->validate($rules);

        foreach (['doc_page_hero_image', 'doc_seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $existing = GlobalSetting::get($field);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$field] = $request->file($field)->store('doctors-settings', 'public');
            } else {
                unset($data[$field]);
            }
        }

        if (empty($data['doc_seo_keywords'])) {
            $titleText = $data['doc_seo_title'] ?? GlobalSetting::getTranslatedArray('doc_seo_title');
            $descText  = $data['doc_seo_description'] ?? GlobalSetting::getTranslatedArray('doc_seo_description');
            $data['doc_seo_keywords'] = $this->autoKeywords(
                is_array($titleText) ? implode(' ', $titleText) : $titleText,
                is_array($descText) ? implode(' ', $descText) : $descText
            );
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Doctors settings saved.');
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
