<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Api\LostFoundApiController;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes v1
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('lang/{locale}', [LanguageController::class, 'switch'])
    ->where('locale', implode('|', config('app.available_locales')))
    ->name('lang.switch');

// Lost & Found Items
Route::prefix('items')->group(function () {
    Route::get('/', [LostFoundApiController::class, 'index']);
    Route::get('/{id}', [LostFoundApiController::class, 'show']);
    Route::get('/slug/{slug}', [LostFoundApiController::class, 'showBySlug']);
});

// Claimer
Route::prefix('claimer')->group(function () {
    Route::post('/signin', [LostFoundApiController::class, 'login']);
    Route::post('/signup', [LostFoundApiController::class, 'register']);

    // Authenticated Claimer Routes
    Route::middleware(['auth:sanctum', 'claimer'])->group(function () {
        Route::post('/claimer/tokens/create', function (Request $request) {
            $token = $request->user()->createToken($request->token_name, ['claimer']);
            return ['token' => $token->plainTextToken];
        });
        Route::post('/logout', [LostFoundApiController::class, 'logout']);
        Route::get('/dashboard', [LostFoundApiController::class, 'dashboard']);
    });
});

// Admin Routes
Route::prefix('admin')->middleware(['auth:sanctum', 'verified', 'auth'])->group(function () {
    Route::apiResource('lost-items', LostFoundApiController::class)->except(['index', 'show']);
    Route::post('lost-items/{id}/status', [LostFoundApiController::class, 'updateStatus']);
});

// Item Submission (authenticated users)
Route::post('/post-item', [LostFoundApiController::class, 'store'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request, Response $response) {
        return $response->json([$request, $response]);
    });

    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name, ['*']);
        return ['token' => $token->plainTextToken];
    });

    Route::get('/tokens', function (Request $request) {
        return $request->user()->tokens;
    });

    Route::delete('/tokens/{id}', function (Request $request, $id) {
        $request->user()->tokens()->where('id', $id)->delete();
        return response()->noContent();
    });
});
