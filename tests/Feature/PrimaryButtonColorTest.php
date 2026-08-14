<?php

declare(strict_types=1);

use App\Models\SiteSetting;

test('primary button color can be persisted', function () {
    $settings = SiteSetting::instance();

    $settings->update(['button_color' => '#123ABC']);

    expect($settings->fresh()->button_color)->toBe('#123ABC');
});

test('public pages expose the configured primary button color', function (string $url) {
    SiteSetting::instance()->update(['button_color' => '#123ABC']);

    $this->get($url)
        ->assertSuccessful()
        ->assertSee('--btn-primary: #123ABC;', false);
})->with(['/', '/portfolio', '/kontak']);

test('public pages use the lime primary button fallback', function (string $url) {
    SiteSetting::instance()->update(['button_color' => null]);

    $this->get($url)
        ->assertSuccessful()
        ->assertSee('--btn-primary: #b5ff41;', false);
})->with(['/', '/portfolio', '/kontak']);

test('only the ten approved primary cta implementations use the global color', function () {
    $buttonViews = collect([
        resource_path('views/components/sections/navbar.blade.php'),
        resource_path('views/components/sections/hero.blade.php'),
        resource_path('views/components/sections/services.blade.php'),
        resource_path('views/components/sections/portfolio.blade.php'),
        resource_path('views/components/sections/footer.blade.php'),
        resource_path('views/contact/index.blade.php'),
    ])->map(fn (string $path): string => file_get_contents($path))->implode("\n");

    expect(substr_count($buttonViews, 'background-color: var(--btn-primary);'))->toBe(10)
        ->and(substr_count($buttonViews, 'hover:brightness-105'))->toBeGreaterThanOrEqual(10)
        ->and($buttonViews)->not->toContain('shadow-emerald-500/20')
        ->and($buttonViews)->not->toContain('shadow-[rgba(181,255,65,0.20)]');
});
