<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotClaimer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('claimer')->check()) {
            return redirect()->route('claimer-login')->with('toast', [
                'type' => 'danger',
                'message' => __('lang_v1.unauthorized_access'),
                'description' => __('lang_v1.you_must_be_logged_in_to_perform_this_action')
            ]);
        }

        if (auth()->guard('web')->check()) {
            return redirect()->route('claimer-login')->with('toast', [
                'type' => 'error',
                'message' => 'Please login as claimer',
                'description' => 'You need to be logged in as a claimer to access this page'
            ]);
        }

        return $next($request);
    }
}
