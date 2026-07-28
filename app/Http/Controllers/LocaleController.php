<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    /**
     * Switch the visitor's language — session + a year-long cookie, no URL
     * prefix. Every route keeps serving the same URL in every language.
     */
    public function update(string $code): RedirectResponse
    {
        abort_unless(Language::active()->pluck('code')->contains($code), 404);

        session(['locale' => $code]);

        return back()->withCookie(cookie('locale', $code, 60 * 24 * 365));
    }
}
