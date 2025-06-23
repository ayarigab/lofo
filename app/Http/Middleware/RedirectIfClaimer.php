<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfClaimer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('claimer')->check()) {
            return redirect()->route('claimer-dashboard')->with('toast', [
                'type' => 'info',
                'message' => 'Already logged in',
                'description' => 'You are already logged in to your account'
            ]);
        }

        return $next($request);
    }
}
