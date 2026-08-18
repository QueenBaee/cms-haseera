<?php

declare(strict_types=1);

use App\Models\Portfolio;
use App\Models\User;
use App\Rules\GoogleDriveVideoUrl;
use Database\Seeders\LandingPageSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

test('portfolio form offers both Google Drive and local video fields', function (): void {
    config()->set('haseera.admin_google_emails', 'admin@example.com');

    $this->actingAs(User::factory()->create(['email' => 'admin@example.com']))
        ->get('/admin/portfolios/create')
        ->assertSuccessful()
        ->assertSee('Google Drive Video URL')
        ->assertSee('Portfolio Video');
});

test('google drive video URLs are parsed into direct stream URLs', function (string $url): void {
    $portfolio = new Portfolio(['gdrive_video_url' => $url]);

    expect($portfolio->gdrive_direct_stream_url)
        ->toBe('https://drive.google.com/uc?export=download&id=1AbCdEfGhIjKlMnOpQRstuVWxyz');
})->with([
    'file URL' => 'https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
    'shared file URL' => 'https://www.drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view?usp=sharing',
    'open URL' => 'https://drive.google.com/open?id=1AbCdEfGhIjKlMnOpQRstuVWxyz',
    'uc URL' => 'https://drive.google.com/uc?id=1AbCdEfGhIjKlMnOpQRstuVWxyz',
]);

test('invalid or untrusted video URLs do not produce a stream URL', function (?string $url): void {
    $portfolio = new Portfolio(['gdrive_video_url' => $url]);

    expect($portfolio->gdrive_direct_stream_url)->toBeNull();
})->with([
    'empty' => null,
    'non-Google host' => 'https://example.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
    'Google lookalike host' => 'https://drive.google.com.example.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
    'insecure scheme' => 'http://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
    'unsupported path' => 'https://drive.google.com/something-invalid',
    'invalid file ID' => 'https://drive.google.com/file/d/video%2Fid/view',
]);

test('google drive video validation rejects non-drive and malformed URLs', function (): void {
    $rule = new GoogleDriveVideoUrl;

    expect(Validator::make(
        ['url' => 'https://example.com/video.mp4'],
        ['url' => ['nullable', 'url', $rule]],
    )->fails())->toBeTrue()
        ->and(Validator::make(
            ['url' => 'https://drive.google.com/something-invalid'],
            ['url' => ['nullable', 'url', $rule]],
        )->fails())->toBeTrue()
        ->and(Validator::make(
            ['url' => 'https://drive.google.com/open?id=1AbCdEfGhIjKlMnOpQRstuVWxyz'],
            ['url' => ['nullable', 'url', $rule]],
        )->passes())->toBeTrue();
});

test('google drive video takes priority over local video and thumbnail', function (): void {
    Storage::fake('public');
    $this->seed(LandingPageSeeder::class);

    $portfolio = Portfolio::query()->firstOrFail();
    $portfolio->update([
        'gdrive_video_url' => 'https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
        'video_file' => 'portfolio-videos/local.mp4',
        'thumbnail' => 'landing-page/portfolios/fallback.webp',
    ]);

    expect(Schema::hasColumn('portfolios', 'gdrive_video_url'))->toBeTrue();

    $this->get('/portfolio')
        ->assertSuccessful()
        ->assertSee('https://drive.google.com/uc?export=download&amp;id=1AbCdEfGhIjKlMnOpQRstuVWxyz', false)
        ->assertDontSee(Storage::disk('public')->url('portfolio-videos/local.mp4'), false)
        ->assertDontSee('<img src="'.asset('storage/landing-page/portfolios/fallback.webp').'"', false);
});

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
