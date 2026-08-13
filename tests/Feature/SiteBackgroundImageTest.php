<?php

declare(strict_types=1);

use App\Models\SiteSetting;

test('site background image can be persisted', function () {
    $settings = SiteSetting::instance();

    $settings->update([
        'background_image' => 'settings/backgrounds/site-background.webp',
    ]);

    expect($settings->fresh()->background_image)
        ->toBe('settings/backgrounds/site-background.webp');
});

test('public pages render the configured background and overlay', function (string $url) {
    SiteSetting::instance()->update([
        'background_image' => 'settings/backgrounds/site-background.webp',
    ]);

    $this->get($url)
        ->assertSuccessful()
        ->assertSee('/storage/settings/backgrounds/site-background.webp', false)
        ->assertSee('fixed inset-0 z-0 bg-black/50 pointer-events-none', false)
        ->assertSee('relative z-10', false);
})->with(['/', '/portfolio', '/kontak']);

test('public pages keep the fallback background without an overlay', function (string $url) {
    SiteSetting::instance()->update(['background_image' => null]);

    $this->get($url)
        ->assertSuccessful()
        ->assertSee('bg-[#111111] text-white antialiased', false)
        ->assertDontSee('fixed inset-0 z-0 bg-black/50 pointer-events-none', false);
})->with(['/', '/portfolio', '/kontak']);
