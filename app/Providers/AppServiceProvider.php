<?php

namespace App\Providers;

use App\Models\DoctorSpecialization;
use App\Models\GlobalSetting;
use App\Models\Language;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    private function bootMailConfig(): void
    {
        try {
            $settings = GlobalSetting::whereIn('key', [
                'mail_enabled', 'mail_driver', 'mail_host', 'mail_port',
                'mail_encryption', 'mail_username', 'mail_password',
                'mail_from_address', 'mail_from_name',
            ])->pluck('value', 'key');

            if ($settings->get('mail_enabled') !== '1') {
                return;
            }

            config([
                'mail.default'                 => $settings->get('mail_driver', 'smtp'),
                'mail.mailers.smtp.host'       => $settings->get('mail_host'),
                'mail.mailers.smtp.port'       => (int) ($settings->get('mail_port') ?: 587),
                'mail.mailers.smtp.encryption' => $settings->get('mail_encryption') ?: null,
                'mail.mailers.smtp.username'   => $settings->get('mail_username'),
                'mail.mailers.smtp.password'   => $settings->get('mail_password'),
                'mail.from.address'            => $settings->get('mail_from_address') ?: config('mail.from.address'),
                'mail.from.name'               => $settings->get('mail_from_name')    ?: config('mail.from.name'),
            ]);
        } catch (\Throwable) {
            // DB not ready (e.g. during migrations) — fall back to .env
        }
    }

    public function boot(): void
    {
        URL::forceRootUrl(config('app.url'));

        $this->bootMailConfig();

        View::composer('*', function ($view) {
            $view->with('headerSettings', $this->headerSettings());
            $view->with('footerSettings', $this->footerSettings());
            $view->with('languages', $this->activeLanguages());
            $view->with('currentLanguage', app()->getLocale());
            $view->with('navDoctorSpecializations', $this->navDoctorSpecializations());
        });
    }

    /** Active specializations for the "Doctor's" nav dropdown. Empty collection if the DB isn't ready. */
    private function navDoctorSpecializations()
    {
        try {
            return DoctorSpecialization::active()->get(['id', 'name', 'slug']);
        } catch (\Throwable) {
            return collect();
        }
    }

    /** All active languages for the language switcher. Empty collection if the DB isn't ready. */
    private function activeLanguages()
    {
        try {
            return Language::active();
        } catch (\Throwable) {
            return collect();
        }
    }

    /** Header keys whose visitor-facing copy is edited per-locale (session/cookie locale, English fallback). */
    private array $headerTranslatableKeys = [
        'header_tagline', 'header_hours', 'header_support_text',
        'header_sidebar_description', 'header_book_btn_text', 'header_address', 'header_phone',
    ];

    /** Pulled from Admin > Global Settings > Header Settings. Empty array if the DB isn't ready. */
    private function headerSettings(): array
    {
        try {
            $settings = GlobalSetting::whereIn('key', [
                'header_logo', 'header_favicon', 'header_site_name', 'header_tagline',
                'header_phone', 'header_email', 'header_address', 'header_hours',
                'header_support_text', 'header_sidebar_description',
                'header_facebook_url', 'header_twitter_url', 'header_instagram_url', 'header_linkedin_url',
                'header_book_btn_text', 'header_book_btn_url',
            ])->pluck('value', 'key')->toArray();

            foreach ($this->headerTranslatableKeys as $key) {
                $settings[$key] = GlobalSetting::getTranslated($key);
            }

            return $settings;
        } catch (\Throwable) {
            return [];
        }
    }

    /** Footer keys whose visitor-facing copy is edited per-locale. */
    private array $footerTranslatableKeys = [
        'footer_brand_description', 'footer_opening_time', 'footer_newsletter_title', 'footer_copyright_text',
        'footer_phone_1', 'footer_phone_2', 'footer_phone_3', 'footer_address_line1', 'footer_address_line2',
    ];

    /** Pulled from Admin > Global Settings > Footer Settings. Empty array if the DB isn't ready. */
    private function footerSettings(): array
    {
        try {
            $settings = GlobalSetting::whereIn('key', [
                'footer_logo', 'footer_brand_description',
                'footer_facebook_url', 'footer_twitter_url', 'footer_instagram_url', 'footer_youtube_url',
                'footer_quick_links', 'footer_service_links', 'footer_store_links', 'footer_useful_links',
                'footer_phone_1', 'footer_phone_2', 'footer_phone_3',
                'footer_email_1', 'footer_email_2',
                'footer_address_line1', 'footer_address_line2', 'footer_website_url', 'footer_opening_time',
                'footer_newsletter_title', 'footer_privacy_url', 'footer_terms_url', 'footer_copyright_text',
                'footer_lets_talk_phone', 'footer_lets_talk_enabled',
                'footer_whatsapp_number', 'footer_whatsapp_enabled',
            ])->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }

        foreach ($this->footerTranslatableKeys as $key) {
            $settings[$key] = GlobalSetting::getTranslated($key);
        }

        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale');

        foreach (['footer_quick_links', 'footer_service_links', 'footer_store_links', 'footer_useful_links'] as $jsonKey) {
            $items = !empty($settings[$jsonKey]) ? json_decode($settings[$jsonKey], true) : [];
            $settings[$jsonKey] = collect($items)->map(function ($item) use ($locale, $fallback) {
                $label = $item['label'] ?? '';
                $item['label'] = is_array($label) ? ($label[$locale] ?: $label[$fallback] ?? '') : $label;
                return $item;
            })->values()->all();
        }

        return $settings;
    }
}
