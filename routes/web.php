<?php

use App\Http\Controllers\Claimer\DashboardController;
use App\Http\Controllers\LostFoundController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimerAuthController;
use App\Models\LostFound;

Route::get('lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])
    ->where('locale', implode('|', config('app.available_locales')))
    ->name('lang.switch');

Route::get('/sitemap.xml', function () {
    $items = LostFound::query()
        ->where(function ($q) {
            $q->whereNull('poster_type')
                ->orWhere('poster_type', '!=', 'guest');
        })
        ->get();
    if ($items->isEmpty()) {
        return response()->view('sitemap', [
            'items' => [],
            'pages' => ['/', '/about', '/contact', '/lost-items', '/post-item', '/claimer/signin', '/claimer/signup', '/claimer/dashboard', '/claimer/logout', '/claimer/claimed-items', '/claimer/claimed-items/{id}', '/claimer/lost-report']
        ])->header('Content-Type', 'text/xml');
    }

    return response()->view('sitemap', [
        'items' => $items,
        'pages' => ['/', '/about', '/contact', '/lost-items', '/post-item', '/claimer/signin', '/claimer/signup', '/claimer/dashboard', '/claimer/logout', '/claimer/claimed-items', '/claimer/claimed-items/{id}', '/claimer/lost-report']
    ])->header('Content-Type', 'text/xml');
});

Route::get('/', [LostFoundController::class, 'home'])->name('home');
Route::get('/post-item', [LostFoundController::class, 'create'])->name('lost-items.store');

Route::get('lost-items', [LostFoundController::class, 'index'])->name('lost-items');
Route::get('lost-items/{id}', [LostFoundController::class, 'show'])->name('lost-items.show');

Route::prefix('claimer')->group(function () {
    Route::middleware(['claimer.guest'])->group(function () {
        Route::get('/signin', function () {
            return view('frontend.signin');
        })->name('claimer-login');

        Route::get('/signup', function () {
            return view('frontend.signup');
        })->name('claimer-register');
    });

    Route::post('/logout', [ClaimerAuthController::class, 'logout'])
        ->name('claimer-logout');

    Route::middleware(['claimer'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('claimer-dashboard');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('claimer-profile');
        Route::get('/change-password', [DashboardController::class, 'changePassword'])->name('claimer-password');
        Route::get('/delete-account', [DashboardController::class, 'deleteAccount'])->name('delete-account');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('claimer-settings');
        Route::post('/verify-password', [DashboardController::class, 'passwordVerify'])->name('claimer-verify-password')->middleware('throttle:3,1');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->middleware(['verified'])
        ->name('dashboard');

    Route::redirect('settings', 'settings/profile');
    Route::view('items', 'items')->name('items');
    Route::view('messages', 'messages')->name('messages');
    Route::view('categories', 'categories')->name('categories');
    Route::view('lost-report', 'lost-report')->name('lost-report');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
})->prefix('admin')->as('admin.');

Route::get('/about', function () {
    return view('frontend.about-us');
})->name('about-us');
Route::get('/contact', function () {
    return view('frontend.contact-us');
})->name('contact-us');

require __DIR__.'/auth.php';
