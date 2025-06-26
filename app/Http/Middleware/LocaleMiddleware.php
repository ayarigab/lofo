<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasSession() && $request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        }
        elseif ($request->hasCookie('locale')) {
            $locale = $request->cookie('locale');
        }

        else {
            $locale = config('app.locale');
        }

        if (in_array($locale, config('app.available_locales'))) {
            App::setLocale($locale);
        }

        return $next($request);
    }

}
