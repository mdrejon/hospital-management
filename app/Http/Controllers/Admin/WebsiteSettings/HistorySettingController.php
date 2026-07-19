<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HistorySettingController extends Controller
{
    private array $keys = [
        'hist_hero_image',
        'hist_hero_title',
        'hist_badge',
        'hist_title',
        'hist_desc',
        'hist_timeline',
        'hist_seo_title',
        'hist_seo_description',
        'hist_seo_keywords',
        'hist_seo_og_image',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->keys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->keys as $key) {
            $settings[$key] ??= null;
        }

        $settings['hist_timeline'] = $settings['hist_timeline']
            ? json_decode($settings['hist_timeline'], true)
            : $this->defaultTimeline();

        return Inertia::render('Admin/WebsiteSettings/History/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'hist_hero_image'       => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'hist_hero_title'       => 'nullable|string',
            'hist_badge'            => 'nullable|string',
            'hist_title'            => 'nullable|string',
            'hist_desc'             => 'nullable|string',
            'hist_timeline'         => 'nullable|array',
            'hist_timeline.*.year'     => 'nullable|string',
            'hist_timeline.*.tag'      => 'nullable|string',
            'hist_timeline.*.heading'  => 'nullable|string',
            'hist_timeline.*.content'  => 'nullable|string',
            'hist_timeline.*.badges'   => 'nullable|array',
            'hist_timeline.*.badges.*' => 'nullable|string',
            'hist_timeline.*.image'    => 'nullable|string',
            'hist_timeline.*.reversed' => 'nullable|boolean',
            'timeline_images'          => 'nullable|array',
            'timeline_images.*'        => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'hist_seo_title'        => 'nullable|string',
            'hist_seo_description'  => 'nullable|string',
            'hist_seo_keywords'     => 'nullable|string',
            'hist_seo_og_image'     => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        // Hero image
        if ($request->hasFile('hist_hero_image')) {
            $existing = GlobalSetting::get('hist_hero_image');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['hist_hero_image'] = $request->file('hist_hero_image')->store('history', 'public');
        } else {
            unset($data['hist_hero_image']);
        }

        // OG image
        if ($request->hasFile('hist_seo_og_image')) {
            $existing = GlobalSetting::get('hist_seo_og_image');
            if ($existing) Storage::disk('public')->delete($existing);
            $data['hist_seo_og_image'] = $request->file('hist_seo_og_image')->store('history', 'public');
        } else {
            unset($data['hist_seo_og_image']);
        }

        // Timeline item images — indexed file uploads
        $timeline = $data['hist_timeline'] ?? [];
        if ($request->hasFile('timeline_images')) {
            foreach ($request->file('timeline_images') as $idx => $file) {
                if (!$file) continue;
                // Delete old image if replacing
                if (!empty($timeline[$idx]['image'])) {
                    Storage::disk('public')->delete($timeline[$idx]['image']);
                }
                $timeline[$idx]['image'] = $file->store('history/timeline', 'public');
            }
        }

        // Clean up timeline: filter empty items, ensure badges is array
        $timeline = array_values(array_filter($timeline, fn($i) => !empty($i['year']) || !empty($i['heading'])));
        foreach ($timeline as &$item) {
            $item['badges']   = array_values(array_filter($item['badges'] ?? []));
            $item['reversed'] = (bool) ($item['reversed'] ?? false);
        }
        unset($item);

        $data['hist_timeline'] = json_encode($timeline);
        unset($data['timeline_images']);

        // Auto-generate keywords if none provided
        if (empty($data['hist_seo_keywords'])) {
            $data['hist_seo_keywords'] = $this->autoKeywords(
                $data['hist_seo_title'] ?? GlobalSetting::get('hist_seo_title', ''),
                $data['hist_seo_description'] ?? GlobalSetting::get('hist_seo_description', ''),
                $data['hist_title'] ?? GlobalSetting::get('hist_title', '')
            );
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'History page settings saved.');
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

    private function defaultTimeline(): array
    {
        $name = config('app.name');

        return [
            ['year' => '2013', 'tag' => 'Foundation',        'heading' => "Founded — {$name} Opens Its Doors",              'content' => "With a vision to bring modern, compassionate healthcare to the community, {$name} opened its doors in 2013.", 'badges' => ['General Medicine', '24/7 Emergency Desk', 'Outpatient Care'], 'image' => '', 'reversed' => false],
            ['year' => '2015', 'tag' => 'Expansion',          'heading' => 'Diagnostic & Laboratory Services Launched',       'content' => 'In 2015, we expanded into in-house diagnostics and laboratory testing, cutting wait times for patients across every department.', 'badges' => ['Diagnostic Lab', 'Radiology', 'Pathology'], 'image' => '', 'reversed' => true],
            ['year' => '2017', 'tag' => 'Growth',             'heading' => 'New Specialist Departments Introduced',           'content' => '2017 marked a major growth phase, with new Cardiology, Pediatrics, and Orthopedics departments and a larger team of specialists.', 'badges' => ['Cardiology', 'Pediatrics', 'Orthopedics'], 'image' => '', 'reversed' => false],
            ['year' => '2019', 'tag' => 'Facilities',         'heading' => 'Intensive Care Unit & Surgical Wing Inaugurated', 'content' => '2019 saw the launch of a fully-equipped ICU and modern surgical wing, enabling critical and post-operative care on-site.', 'badges' => ['ICU', 'Surgical Wing', 'Critical Care'], 'image' => '', 'reversed' => true],
            ['year' => '2021', 'tag' => 'Recognition',        'heading' => 'Recognized for Patient Care Excellence',          'content' => 'By 2021, our commitment to patient outcomes earned recognition as one of the region\'s most trusted healthcare providers.', 'badges' => ['Quality Care Award', 'Top-Rated by Patients', 'Community Trust'], 'image' => '', 'reversed' => false],
            ['year' => '2023', 'tag' => 'Technology & Access','heading' => 'Telemedicine & Digital Records Launched',         'content' => '2023 brought telemedicine consultations and digital patient records, making quality care more accessible than ever.', 'badges' => ['Telemedicine', 'Digital Records', 'Online Appointments'], 'image' => '', 'reversed' => true],
            ['year' => '2025', 'tag' => 'A Decade & Beyond',  'heading' => 'Celebrating Our Patients — The Journey Continues','content' => "Over a decade after opening, {$name} continues to grow as a symbol of trusted, compassionate healthcare in our community.", 'badges' => ['10+ Years of Service', 'Thousands of Patients Served', 'Continuously Growing'], 'image' => '', 'reversed' => false],
        ];
    }
}
