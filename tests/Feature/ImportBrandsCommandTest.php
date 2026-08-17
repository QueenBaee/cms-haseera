<?php

declare(strict_types=1);

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

test('it imports supported brand images and ignores other entries', function () {
    Storage::fake('public');
    Storage::disk('public')->makeDirectory('brands-bulk');
    Storage::disk('public')->put('brands-bulk/logo-bappenas.png', 'png');
    Storage::disk('public')->put('brands-bulk/pt_telkom.WEBP', 'webp');
    Storage::disk('public')->put('brands-bulk/notes.txt', 'text');
    Storage::disk('public')->put('brands-bulk/nested/ignored.svg', 'svg');

    $this->artisan('brands:import')
        ->expectsOutput('[IMPORTED] logo-bappenas.png -> Logo Bappenas')
        ->expectsOutput('[IMPORTED] pt_telkom.WEBP -> Pt Telkom')
        ->expectsOutput('Total files found: 2')
        ->expectsOutput('Successfully imported: 2')
        ->expectsOutput('Skipped: 0')
        ->expectsOutput('Failed: 0')
        ->assertSuccessful();

    expect(Brand::query()->where('logo', 'brands/logo-bappenas.png')->first())
        ->name->toBe('Logo Bappenas')
        ->is_active->toBeTrue()
        ->sort_order->toBe(0)
        ->logo_background->toBe('auto');

    Storage::disk('public')->assertMissing('brands-bulk/logo-bappenas.png');
    Storage::disk('public')->assertExists('brands/logo-bappenas.png');
    Storage::disk('public')->assertExists('brands-bulk/notes.txt');
    Storage::disk('public')->assertExists('brands-bulk/nested/ignored.svg');
});

test('it skips a source image when its logo path already belongs to a brand', function () {
    Storage::fake('public');
    Storage::disk('public')->put('brands-bulk/logo-telkom.png', 'new logo');

    Brand::query()->create([
        'name' => 'Telkom',
        'logo' => 'brands/logo-telkom.png',
    ]);

    $this->artisan('brands:import')
        ->expectsOutput('[SKIPPED] logo-telkom.png -> Brand already exists')
        ->expectsOutput('Successfully imported: 0')
        ->expectsOutput('Skipped: 1')
        ->expectsOutput('Failed: 0')
        ->assertSuccessful();

    expect(Brand::query()->where('logo', 'brands/logo-telkom.png')->count())->toBe(1);
    Storage::disk('public')->assertExists('brands-bulk/logo-telkom.png');
});

test('it reports a destination collision and continues importing remaining files', function () {
    Storage::fake('public');
    Storage::disk('public')->put('brands-bulk/collision.jpg', 'source');
    Storage::disk('public')->put('brands-bulk/success.svg', 'source');
    Storage::disk('public')->put('brands/collision.jpg', 'existing');

    $this->artisan('brands:import')
        ->expectsOutput('[ERROR] collision.jpg -> Destination file already exists')
        ->expectsOutput('[IMPORTED] success.svg -> Success')
        ->expectsOutput('Successfully imported: 1')
        ->expectsOutput('Failed: 1')
        ->assertFailed();

    Storage::disk('public')->assertExists('brands-bulk/collision.jpg');
    Storage::disk('public')->assertExists('brands/success.svg');
    $this->assertDatabaseHas('brands', ['logo' => 'brands/success.svg']);
});

test('it fails when the source directory is missing', function () {
    Storage::fake('public');

    $this->artisan('brands:import')
        ->expectsOutput('[ERROR] Source directory does not exist: storage/app/public/brands-bulk')
        ->assertFailed();
});
