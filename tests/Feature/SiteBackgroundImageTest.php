<?php

declare(strict_types=1);

use App\Filament\Pages\ManageSiteSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Livewire\Livewire;

test('background image uploads allow up to 50 MB at both upload validation layers', function (): void {
    config()->set('haseera.admin_google_emails', 'admin@example.com');

    $this->actingAs(User::factory()->create(['email' => 'admin@example.com']));

    expect(config('livewire.temporary_file_upload.rules'))
        ->toBe(['required', 'file', 'max:51200']);

    Livewire::test(ManageSiteSettings::class)
        ->assertSchemaComponentExists(
            'background_image',
            checkComponentUsing: fn (FileUpload $component): bool => $component->getMaxSize() === 51200
                && $component->getAcceptedFileTypes() === ['image/jpeg', 'image/png', 'image/webp']
                && $component->shouldPreventFilePathTampering(),
        );
});

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
