<?php

namespace App\Providers;

use App\Models\GlobalSetting;
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
        });
    }

    /** Pulled from Admin > Global Settings > Header Settings. Empty array if the DB isn't ready. */
    private function headerSettings(): array
    {
        try {
            return GlobalSetting::whereIn('key', [
                'header_logo', 'header_site_name', 'header_tagline',
                'header_phone', 'header_email', 'header_address', 'header_hours',
                'header_support_text', 'header_sidebar_description',
                'header_facebook_url', 'header_twitter_url', 'header_instagram_url', 'header_linkedin_url',
                'header_book_btn_text', 'header_book_btn_url',
            ])->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }
    }

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
            ])->pluck('value', 'key')->toArray();
        } catch (\Throwable) {
            return [];
        }

        foreach (['footer_quick_links', 'footer_service_links', 'footer_store_links', 'footer_useful_links'] as $jsonKey) {
            $settings[$jsonKey] = !empty($settings[$jsonKey]) ? json_decode($settings[$jsonKey], true) : [];
        }

        return $settings;
    }
}
