<?php

declare(strict_types=1);

use App\Models\Portfolio;
use App\Models\User;
use App\Rules\GoogleDriveVideoUrl;
use App\Rules\YouTubeVideoUrl;
use Database\Seeders\LandingPageSeeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

test('portfolio form offers both Google Drive and local video fields', function (): void {
    config()->set('haseera.admin_google_emails', 'admin@example.com');

    $this->actingAs(User::factory()->create(['email' => 'admin@example.com']))
        ->get('/admin/portfolios/create')
        ->assertSuccessful()
        ->assertSee('YouTube Video URL')
        ->assertSee('Google Drive Video URL')
        ->assertSee('Portfolio Video');
});

test('youtube video URLs are parsed into autoplaying embed URLs', function (string $url): void {
    $portfolio = new Portfolio(['youtube_video_url' => $url]);

    expect($portfolio->youtube_embed_url)
        ->toBe('https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&mute=1&controls=0&loop=1&playlist=dQw4w9WgXcQ&playsinline=1');
})->with([
    'www watch URL' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    'watch URL with parameters' => 'https://youtube.com/watch?v=dQw4w9WgXcQ&t=30&feature=shared',
    'mobile watch URL' => 'https://m.youtube.com/watch?v=dQw4w9WgXcQ',
    'short URL' => 'https://youtu.be/dQw4w9WgXcQ?si=example',
    'www short URL' => 'https://www.youtu.be/dQw4w9WgXcQ',
    'shorts URL' => 'https://www.youtube.com/shorts/dQw4w9WgXcQ',
    'embed URL' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
]);

test('invalid or untrusted youtube URLs do not produce an embed URL', function (?string $url): void {
    $portfolio = new Portfolio(['youtube_video_url' => $url]);

    expect($portfolio->youtube_embed_url)->toBeNull();
})->with([
    'empty' => null,
    'non-YouTube host' => 'https://example.com/watch?v=dQw4w9WgXcQ',
    'YouTube lookalike host' => 'https://youtube.com.example.com/watch?v=dQw4w9WgXcQ',
    'insecure scheme' => 'http://youtube.com/watch?v=dQw4w9WgXcQ',
    'unsupported path' => 'https://youtube.com/channel/dQw4w9WgXcQ',
    'short video ID' => 'https://youtube.com/watch?v=too-short',
    'invalid video ID' => 'https://youtube.com/watch?v=invalid%2Fid',
]);

test('youtube video validation rejects non-youtube and malformed URLs', function (): void {
    $rule = new YouTubeVideoUrl;

    expect(Validator::make(
        ['url' => 'https://example.com/watch?v=dQw4w9WgXcQ'],
        ['url' => ['nullable', 'url', $rule]],
    )->fails())->toBeTrue()
        ->and(Validator::make(
            ['url' => 'https://youtube.com/watch?v=too-short'],
            ['url' => ['nullable', 'url', $rule]],
        )->fails())->toBeTrue()
        ->and(Validator::make(
            ['url' => 'https://youtu.be/dQw4w9WgXcQ'],
            ['url' => ['nullable', 'url', $rule]],
        )->passes())->toBeTrue();
});

test('google drive video URLs are parsed into preview embed URLs', function (string $url): void {
    $portfolio = new Portfolio(['gdrive_video_url' => $url]);

    expect($portfolio->gdrive_embed_url)
        ->toBe('https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/preview');
})->with([
    'file URL' => 'https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
    'shared file URL' => 'https://www.drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view?usp=sharing',
    'open URL' => 'https://drive.google.com/open?id=1AbCdEfGhIjKlMnOpQRstuVWxyz',
    'uc URL' => 'https://drive.google.com/uc?id=1AbCdEfGhIjKlMnOpQRstuVWxyz',
]);

test('invalid or untrusted video URLs do not produce an embed URL', function (?string $url): void {
    $portfolio = new Portfolio(['gdrive_video_url' => $url]);

    expect($portfolio->gdrive_embed_url)->toBeNull();
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
        ->assertSee('<iframe src="https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/preview"', false)
        ->assertDontSee(Storage::disk('public')->url('portfolio-videos/local.mp4'), false)
        ->assertDontSee('<img src="'.asset('storage/landing-page/portfolios/fallback.webp').'"', false);
});

test('youtube video takes priority over all other portfolio media', function (): void {
    Storage::fake('public');
    $this->seed(LandingPageSeeder::class);

    $portfolio = Portfolio::query()->firstOrFail();
    $portfolio->update([
        'youtube_video_url' => 'https://youtu.be/dQw4w9WgXcQ',
        'gdrive_video_url' => 'https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
        'video_file' => 'portfolio-videos/local.mp4',
        'thumbnail' => 'landing-page/portfolios/fallback.webp',
    ]);

    expect(Schema::hasColumn('portfolios', 'youtube_video_url'))->toBeTrue();

    $this->get('/portfolio')
        ->assertSuccessful()
        ->assertSee('<iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&amp;mute=1&amp;controls=0&amp;loop=1&amp;playlist=dQw4w9WgXcQ&amp;playsinline=1"', false)
        ->assertSee('pointer-events-none', false)
        ->assertDontSee('https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/preview', false)
        ->assertDontSee(Storage::disk('public')->url('portfolio-videos/local.mp4'), false)
        ->assertDontSee('<img src="'.asset('storage/landing-page/portfolios/fallback.webp').'"', false);
});

test('invalid youtube video falls back to google drive', function (): void {
    $this->seed(LandingPageSeeder::class);

    $portfolio = Portfolio::query()->firstOrFail();
    $portfolio->update([
        'youtube_video_url' => 'https://youtube.com.example.com/watch?v=dQw4w9WgXcQ',
        'gdrive_video_url' => 'https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/view',
    ]);

    $this->get('/portfolio')
        ->assertSuccessful()
        ->assertSee('<iframe src="https://drive.google.com/file/d/1AbCdEfGhIjKlMnOpQRstuVWxyz/preview"', false)
        ->assertDontSee('https://www.youtube.com/embed/', false);
});

test('invalid google drive video falls back to the local video', function (): void {
    Storage::fake('public');
    $this->seed(LandingPageSeeder::class);

    $portfolio = Portfolio::query()->firstOrFail();
    $portfolio->update([
        'gdrive_video_url' => 'https://example.com/file/d/untrusted/view',
        'video_file' => 'portfolio-videos/local.mp4',
        'thumbnail' => 'landing-page/portfolios/fallback.webp',
    ]);

    $this->get('/portfolio')
        ->assertSuccessful()
        ->assertSee('<video autoplay muted loop playsinline', false)
        ->assertSee(Storage::disk('public')->url('portfolio-videos/local.mp4'), false)
        ->assertDontSee('<iframe', false)
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
