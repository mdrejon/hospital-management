<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ContactSettingController extends Controller
{
    private array $keys = [
        // Hero & Breadcrumb
        'contact_hero_image',
        'contact_hero_title',
        // SEO
        'contact_seo_title',
        'contact_seo_description',
        'contact_seo_keywords',
        'contact_seo_og_image',
        // Main content (left column)
        'contact_title',
        'contact_desc',
        'contact_talk_text',
        'contact_rating_score',
        'contact_rating_text',
        // Contact info (shared with header/footer)
        'footer_phone_1',
        'footer_phone_2',
        'footer_phone_3',
        'footer_email_1',
        'footer_email_2',
        'footer_address_line1',
        'footer_address_line2',
        // Social (shared with footer)
        'footer_facebook_url',
        'footer_twitter_url',
        'footer_instagram_url',
        'footer_youtube_url',
        // Contact form card (right column)
        'contact_form_title',
        'contact_form_btn_text',
        // Google Maps
        'contact_map_embed',
        'contact_map_open_url',
    ];

    public function edit(): Response
    {
        $settings = GlobalSetting::whereIn('key', $this->keys)
            ->pluck('value', 'key')
            ->toArray();

        foreach ($this->keys as $key) {
            $settings[$key] ??= null;
        }

        return Inertia::render('Admin/WebsiteSettings/Contact/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'contact_hero_title'        => 'nullable|string',
            'contact_hero_image'        => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'contact_seo_title'         => 'nullable|string',
            'contact_seo_description'   => 'nullable|string',
            'contact_seo_keywords'      => 'nullable|string',
            'contact_seo_og_image'      => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'contact_title'          => 'nullable|string',
            'contact_desc'            => 'nullable|string',
            'contact_talk_text'       => 'nullable|string',
            'contact_rating_score'    => 'nullable|string',
            'contact_rating_text'     => 'nullable|string',
            'footer_phone_1'        => 'nullable|string',
            'footer_phone_2'        => 'nullable|string',
            'footer_phone_3'        => 'nullable|string',
            'footer_email_1'        => 'nullable|email',
            'footer_email_2'        => 'nullable|email',
            'footer_address_line1'  => 'nullable|string',
            'footer_address_line2'  => 'nullable|string',
            'footer_facebook_url'   => 'nullable|string',
            'footer_twitter_url'    => 'nullable|string',
            'footer_instagram_url'  => 'nullable|string',
            'footer_youtube_url'    => 'nullable|string',
            'contact_form_title'    => 'nullable|string',
            'contact_form_btn_text' => 'nullable|string',
            'contact_map_embed'     => 'nullable|string',
            'contact_map_open_url'  => 'nullable|string',
        ]);

        foreach (['contact_hero_image', 'contact_seo_og_image'] as $imgKey) {
            if ($request->hasFile($imgKey)) {
                $existing = GlobalSetting::get($imgKey);
                if ($existing) Storage::disk('public')->delete($existing);
                $data[$imgKey] = $request->file($imgKey)->store('contact', 'public');
            } else {
                unset($data[$imgKey]);
            }
        }

        // Auto-generate keywords if none provided
        if (empty($data['contact_seo_keywords'])) {
            $data['contact_seo_keywords'] = $this->autoKeywords(
                $data['contact_seo_title'] ?? GlobalSetting::get('contact_seo_title', ''),
                $data['contact_seo_description'] ?? GlobalSetting::get('contact_seo_description', '')
            );
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Contact settings saved.');
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
