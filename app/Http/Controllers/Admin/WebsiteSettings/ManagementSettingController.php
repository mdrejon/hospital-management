<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagementSettingController extends Controller
{
    private array $keys = [
        'mgmt_hero_image',
        'mgmt_hero_title',
        'mgmt_badge',
        'mgmt_title',
        'mgmt_seo_title',
        'mgmt_seo_description',
        'mgmt_seo_keywords',
        'mgmt_seo_og_image',
    ];

    /** Used by Admin\ManagementMemberController::index() to feed the "Page Settings" tab. */
    public function currentSettings(): array
    {
        $settings = GlobalSetting::whereIn('key', $this->keys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->keys as $key) {
            $settings[$key] ??= null;
        }

        return $settings;
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mgmt_hero_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'mgmt_hero_title'      => 'nullable|string',
            'mgmt_badge'           => 'nullable|string',
            'mgmt_title'           => 'nullable|string',
            'mgmt_seo_title'       => 'nullable|string',
            'mgmt_seo_description' => 'nullable|string',
            'mgmt_seo_keywords'    => 'nullable|string',
            'mgmt_seo_og_image'    => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        foreach (['mgmt_hero_image', 'mgmt_seo_og_image'] as $imgKey) {
            if ($request->hasFile($imgKey)) {
                $existing = GlobalSetting::get($imgKey);
                if ($existing) Storage::disk('public')->delete($existing);
                $data[$imgKey] = $request->file($imgKey)->store('management-settings', 'public');
            } else {
                unset($data[$imgKey]);
            }
        }

        if (empty($data['mgmt_seo_keywords'])) {
            $data['mgmt_seo_keywords'] = $this->autoKeywords(
                $data['mgmt_seo_title'] ?? GlobalSetting::get('mgmt_seo_title', ''),
                $data['mgmt_seo_description'] ?? GlobalSetting::get('mgmt_seo_description', '')
            );
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Management settings saved.');
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
