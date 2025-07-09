<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimerAuthController extends Controller
{
    public static function logout(Request $request)
    {
        Auth::guard('claimer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('claimer-login')->with('toast', [
            'type' => 'info',
            'message' => 'Logged out successfully.',
            'description' => 'You are logged out successfully. To access dashboard, you have to login again'
        ]);
    }
}
