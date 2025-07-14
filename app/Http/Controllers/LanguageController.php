<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale): RedirectResponse
    {
        if (!in_array($locale, config('app.available_locales'))) {
            abort(400, __('lang_v1.invalid_local'));
        }

        App::setLocale($locale);

        session()->put('locale', $locale);

        Carbon::setLocale($locale);

        setlocale(LC_TIME, $locale);

        return redirect()->back()
            ->withCookie(cookie()->forever('locale', $locale))
            ->with('locale_updated', true);
    }
}
