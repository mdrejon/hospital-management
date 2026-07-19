<?php

namespace App\Http\Controllers\Admin\WebsiteSettings;

use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppointmentSettingController extends Controller
{
    private array $keys = [
        // "Book Appointment" section (shown on Home + the Appointment page)
        'appt_badge',
        'appt_title',
        'appt_form_title',
        'appt_form_subtitle',
        'appt_image',
        // Appointment page hero / breadcrumb
        'appt_page_hero_image',
        'appt_page_hero_title',
        // SEO (appointment page)
        'appt_seo_title',
        'appt_seo_description',
        'appt_seo_keywords',
        'appt_seo_og_image',
    ];

    /** Used by Admin\AppointmentController::index() to feed the "Page Settings" tab. */
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
            'appt_badge'            => 'nullable|string',
            'appt_title'            => 'nullable|string',
            'appt_form_title'       => 'nullable|string',
            'appt_form_subtitle'    => 'nullable|string',
            'appt_image'            => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'appt_page_hero_image'  => 'nullable|image|mimes:jpeg,jpg,png,webp',
            'appt_page_hero_title'  => 'nullable|string',
            'appt_seo_title'        => 'nullable|string',
            'appt_seo_description'  => 'nullable|string',
            'appt_seo_keywords'     => 'nullable|string',
            'appt_seo_og_image'     => 'nullable|image|mimes:jpeg,jpg,png,webp',
        ]);

        foreach (['appt_image', 'appt_page_hero_image', 'appt_seo_og_image'] as $field) {
            if ($request->hasFile($field)) {
                $existing = GlobalSetting::get($field);
                if ($existing) {
                    Storage::disk('public')->delete($existing);
                }
                $data[$field] = $request->file($field)->store('appointment-settings', 'public');
            } else {
                unset($data[$field]);
            }
        }

        if (empty($data['appt_seo_keywords'])) {
            $data['appt_seo_keywords'] = $this->autoKeywords(
                $data['appt_seo_title'] ?? GlobalSetting::get('appt_seo_title', ''),
                $data['appt_seo_description'] ?? GlobalSetting::get('appt_seo_description', '')
            );
        }

        GlobalSetting::setMany($data);

        return back()->with('success', 'Appointment settings saved.');
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
