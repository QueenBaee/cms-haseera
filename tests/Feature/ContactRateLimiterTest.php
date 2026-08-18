<?php

declare(strict_types=1);

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

test('contact route uses the registered contact rate limiter', function (): void {
    $route = Route::getRoutes()->getByName('contact.store');
    $limiter = RateLimiter::limiter('contact');

    expect($route)->not->toBeNull()
        ->and($route?->gatherMiddleware())->toContain('throttle:contact')
        ->and($route?->gatherMiddleware())->not->toContain('throttle:App\Models\User::contact')
        ->and($limiter)->not->toBeNull()
        ->and($limiter(request()))->toBeInstanceOf(Limit::class);
});

test('contact submissions return a normal too many requests response after the limit', function (): void {
    $payload = [
        'name' => 'Test Contact',
        'email' => 'contact@example.com',
        'message' => 'A valid contact message.',
    ];

    foreach (range(1, 5) as $attempt) {
        $this->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact.index'));
    }

    $this->post(route('contact.store'), $payload)
        ->assertTooManyRequests();
});
