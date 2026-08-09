<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

RateLimiter::for('contact', function ($request) {
    return Limit::perMinute(5)->by($request->ip());
});

Route::get('/', HomeController::class)->name('home');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

Route::middleware('guest')->group(function (): void {
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');
