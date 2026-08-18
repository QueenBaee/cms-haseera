<?php

declare(strict_types=1);

use App\Models\Portfolio;
use Database\Seeders\LandingPageSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

test('portfolio videos are persisted and rendered with autoplay attributes', function (): void {
    Storage::fake('public');
    $this->seed(LandingPageSeeder::class);

    $portfolio = Portfolio::query()->firstOrFail();
    $portfolio->update([
        'thumbnail' => 'landing-page/portfolios/fallback.webp',
        'video_file' => 'portfolio-videos/demo.webm',
    ]);

    expect(Schema::hasColumn('portfolios', 'video_file'))->toBeTrue()
        ->and($portfolio->fresh()->video_file)->toBe('portfolio-videos/demo.webm');

    $this->get('/portfolio')
        ->assertSuccessful()
        ->assertSee('<video autoplay muted loop playsinline', false)
        ->assertSee(Storage::disk('public')->url('portfolio-videos/demo.webm'), false)
        ->assertSee('type="video/webm"', false)
        ->assertDontSee('<img src="'.asset('storage/landing-page/portfolios/fallback.webp').'"', false);
});

test('portfolio images continue to render when no video exists', function (): void {
    $this->seed(LandingPageSeeder::class);

    $portfolio = Portfolio::query()->firstOrFail();
    $portfolio->update([
        'thumbnail' => 'landing-page/portfolios/thumbnail.webp',
        'video_file' => null,
    ]);

    $this->get('/portfolio')
        ->assertSuccessful()
        ->assertSee(asset('storage/landing-page/portfolios/thumbnail.webp'), false);
});
