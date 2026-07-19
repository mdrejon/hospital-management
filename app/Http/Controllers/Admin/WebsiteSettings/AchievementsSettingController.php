<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AchievementsSettingController extends Controller
{
    private array $keys = [
        'ach_hero_image',
        'ach_hero_title',
        'ach_title',
        'ach_desc',
        'ach_items',
        'ach_seo_title',
        'ach_seo_description',
        'ach_seo_keywords',
        'ach_seo_og_image',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->keys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->keys as $key) {
            $settings[$key] ??= null;
        }

        $settings['ach_items'] = $settings['ach_items'] ? json_decode($settings['ach_items'], true) : $this->defaultItems();

        return Inertia::render('Admin/WebsiteSettings/Achievements/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ach_hero_image'       => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'ach_hero_title'       => 'nullable|string',
            'ach_title'            => 'nullable|string',
            'ach_desc'             => 'nullable|string',
            'ach_items'            => 'nullable|array|max:3',
            'ach_items.*.title'    => 'nullable|string',
            'ach_items.*.desc'     => 'nullable|string',
            'ach_seo_title'        => 'nullable|string',
            'ach_seo_description'  => 'nullable|string',
            'ach_seo_keywords'     => 'nullable|string',
            'ach_seo_og_image'     => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        foreach (['ach_hero_image', 'ach_seo_og_image'] as $imgKey) {
            if ($request->hasFile($imgKey)) {
                $existing = GlobalSetting::get($imgKey);
                if ($existing) Storage::disk('public')->delete($existing);
                $data[$imgKey] = $request->file($imgKey)->store('achievements', 'public');
            } else {
                unset($data[$imgKey]);
            }
        }

        $items = array_values(array_filter($data['ach_items'] ?? [], fn ($i) => !empty($i['title']) || !empty($i['desc'])));
        $data['ach_items'] = json_encode($items);

        if (empty($data['ach_seo_keywords'])) {
            $data['ach_seo_keywords'] = $this->autoKeywords(
                $data['ach_seo_title'] ?? GlobalSetting::get('ach_seo_title', ''),
                $data['ach_seo_description'] ?? GlobalSetting::get('ach_seo_description', '')
            );
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Achievements page settings saved.');
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

    private function defaultItems(): array
    {
        return [
            ['title' => 'Emergency Help',     'desc' => 'Round-the-clock ambulance and emergency response, ready whenever you need us most.'],
            ['title' => 'Enriched Pharmacy',  'desc' => 'A fully stocked in-house pharmacy with genuine medicines and expert pharmacists.'],
            ['title' => 'Medical Treatment',  'desc' => 'Comprehensive specialist care and modern treatment across every department.'],
        ];
    }
}
