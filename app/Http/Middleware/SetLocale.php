<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Resolve the visitor's locale from the session, falling back to a
     * long-lived cookie, then the default language — no URL prefix (no
     * `/en`, `/bn`), so every route serves every language at the same URL.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeCodes = Language::active()->pluck('code')->all();

        $locale = $request->session()->get('locale');

        if (! in_array($locale, $activeCodes, true)) {
            $locale = $request->cookie('locale');
        }

        if (! in_array($locale, $activeCodes, true)) {
            $locale = Language::defaultLanguage()?->code ?? config('app.locale');
        }

        App::setLocale($locale);
        $request->session()->put('locale', $locale);

        return $next($request);
    }
}
