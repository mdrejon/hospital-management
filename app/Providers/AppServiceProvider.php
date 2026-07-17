<?php

namespace App\Providers;

use App\Models\GlobalSetting;
use Illuminate\Support\Facades\URL;
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
    }
}
