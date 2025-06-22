<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimerAuthController extends Controller
{
    public function logout()
    {
        Auth::guard('claimer')->logout();
        return redirect('/claimer/login');
    }
}
