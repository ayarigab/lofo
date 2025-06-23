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
                'message' => 'Oops! Access denied',
                'description' => 'You need to be logged in to access this page.'
            ]);
        }

        if (auth()->guard('web')->check()) {
            // auth()->guard('web')->logout();
            return redirect()->route('claimer-login')->with('toast', [
                'type' => 'error',
                'message' => 'Please login as claimer',
                'description' => 'You need to be logged in as a claimer to access this page'
            ]);
        }

        return $next($request);
    }
}
