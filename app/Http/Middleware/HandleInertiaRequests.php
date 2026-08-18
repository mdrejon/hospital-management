<?php

namespace App\Http\Middleware;

use App\Models\GlobalSetting;
use App\Models\Language;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'auth' => [
                'user'        => $user,
                'permissions' => $user?->sharedPermissions(), // null = super admin (full access)
                'role_name'   => $user ? ($user->isSuperAdmin() ? 'Super Admin' : ($user->role?->name ?? 'Admin')) : null,
            ],
            'ziggy' => fn () => [
                ...(new \Tighten\Ziggy\Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],
            'languages' => fn () => Language::active(),
            'currentLanguage' => fn () => app()->getLocale(),
            'appName' => config('app.name'),
            'site' => fn () => [
                'name'      => GlobalSetting::get('header_site_name', config('app.name')),
                'logo'      => GlobalSetting::get('header_logo'),
                'tagline'   => GlobalSetting::get('site_tagline', 'Compassionate Care, Trusted Doctors'),
                'phone'     => GlobalSetting::get('contact_phone', GlobalSetting::getTranslated('header_phone', null, '')),
                'email'     => GlobalSetting::get('contact_email', GlobalSetting::get('header_email', '')),
                'address'   => GlobalSetting::get('contact_address', ''),
                'facebook'  => GlobalSetting::get('footer_facebook', ''),
                'instagram' => GlobalSetting::get('footer_instagram', ''),
                'twitter'   => GlobalSetting::get('footer_twitter', ''),
                'youtube'   => GlobalSetting::get('footer_youtube', ''),
                'copyright' => GlobalSetting::get('footer_copyright', '© ' . date('Y') . ' Hotel Beach Way. All rights reserved.'),
            ],
        ];
    }
}
