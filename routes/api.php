<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes version v1
|--------------------------------------------------------------------------
*/


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(base_path('routes/api_v1.php'));

Route::fallback(function () {
    return response()->json([
        'message' => 'API version not specified or invalid. Please use v1.'
    ], 404);
});
