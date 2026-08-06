<?php

declare(strict_types=1);

use App\Models\AboutFeature;
use App\Models\AboutSection;
use App\Models\CallToActionSetting;
use App\Models\CompanyStatistic;
use App\Models\HeroSlide;
use App\Models\LandingPageSetting;
use App\Models\NavigationItem;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioImage;
use App\Models\Service;
use App\Models\SocialMediaLink;
use App\Models\Testimonial;
use App\Models\User;
use App\Rules\InternalOrExternalUrl;
use App\Services\LandingPageService;
use Database\Seeders\LandingPageSeeder;
use Illuminate\Support\Facades\Cache;

// ─── Seeder idempotent ────────────────────────────────────────────────────────

test('seeder is idempotent — running twice produces correct counts', function () {
    $this->seed(LandingPageSeeder::class);
    $this->seed(LandingPageSeeder::class);

    expect(LandingPageSetting::count())->toBe(1);
    expect(CallToActionSetting::count())->toBe(1);
    expect(NavigationItem::count())->toBe(5);
    expect(HeroSlide::count())->toBe(2);
    expect(CompanyStatistic::count())->toBe(4);
    expect(AboutSection::count())->toBe(1);
    expect(AboutFeature::count())->toBe(4);
    expect(Service::count())->toBe(4);
    expect(PortfolioCategory::count())->toBe(3);
    expect(Portfolio::count())->toBe(6);
    expect(Testimonial::count())->toBe(4);
    expect(SocialMediaLink::count())->toBe(4);
});

// ─── Singleton settings ───────────────────────────────────────────────────────

test('LandingPageSetting is singleton — updateOrCreate never creates second record', function () {
    LandingPageSetting::updateOrCreate(['id' => 1], ['site_name' => 'First']);
    LandingPageSetting::updateOrCreate(['id' => 1], ['site_name' => 'Second']);

    expect(LandingPageSetting::count())->toBe(1);
    expect(LandingPageSetting::first()->site_name)->toBe('Second');
});

test('CallToActionSetting is singleton — updateOrCreate never creates second record', function () {
    CallToActionSetting::updateOrCreate(['id' => 1], ['title' => 'First CTA']);
    CallToActionSetting::updateOrCreate(['id' => 1], ['title' => 'Second CTA']);

    expect(CallToActionSetting::count())->toBe(1);
    expect(CallToActionSetting::first()->title)->toBe('Second CTA');
});

// ─── HeroSlide scopes ─────────────────────────────────────────────────────────

test('HeroSlide published scope returns only active slides with past or null published_at', function () {
    HeroSlide::create(['title' => 'Active No Date', 'is_active' => true, 'published_at' => null, 'sort_order' => 1]);
    HeroSlide::create(['title' => 'Active Past', 'is_active' => true, 'published_at' => now()->subDay(), 'sort_order' => 2]);
    HeroSlide::create(['title' => 'Active Future', 'is_active' => true, 'published_at' => now()->addDay(), 'sort_order' => 3]);
    HeroSlide::create(['title' => 'Inactive', 'is_active' => false, 'published_at' => null, 'sort_order' => 4]);

    $published = HeroSlide::published()->get();

    expect($published)->toHaveCount(2);
    expect($published->pluck('title')->toArray())->toContain('Active No Date', 'Active Past');
});

test('HeroSlide ordered scope sorts by sort_order then updated_at desc', function () {
    HeroSlide::create(['title' => 'B', 'is_active' => true, 'sort_order' => 2]);
    HeroSlide::create(['title' => 'A', 'is_active' => true, 'sort_order' => 1]);

    $slides = HeroSlide::ordered()->get();

    expect($slides->first()->title)->toBe('A');
});

// ─── Active and ordered scopes ────────────────────────────────────────────────

test('CompanyStatistic active scope filters inactive records', function () {
    CompanyStatistic::create(['value' => '10', 'label' => 'Active Stat', 'is_active' => true, 'sort_order' => 1]);
    CompanyStatistic::create(['value' => '20', 'label' => 'Inactive Stat', 'is_active' => false, 'sort_order' => 2]);

    expect(CompanyStatistic::active()->count())->toBe(1);
    expect(CompanyStatistic::active()->first()->label)->toBe('Active Stat');
});

test('NavigationItem active scope filters inactive records', function () {
    NavigationItem::create(['label' => 'Active', 'url' => '#', 'navigation_location' => 'header', 'is_active' => true, 'sort_order' => 1]);
    NavigationItem::create(['label' => 'Inactive', 'url' => '#', 'navigation_location' => 'header', 'is_active' => false, 'sort_order' => 2]);

    expect(NavigationItem::active()->count())->toBe(1);
});

test('Service active scope filters inactive records', function () {
    Service::create(['title' => 'Active Service', 'is_active' => true, 'sort_order' => 1]);
    Service::create(['title' => 'Inactive Service', 'is_active' => false, 'sort_order' => 2]);

    expect(Service::active()->count())->toBe(1);
});

test('Testimonial active scope filters inactive records', function () {
    Testimonial::create(['name' => 'Active', 'content' => 'Good', 'is_active' => true, 'sort_order' => 1]);
    Testimonial::create(['name' => 'Inactive', 'content' => 'Bad', 'is_active' => false, 'sort_order' => 2]);

    expect(Testimonial::active()->count())->toBe(1);
});

// ─── Relasi AboutFeature ──────────────────────────────────────────────────────

test('AboutSection has many AboutFeatures', function () {
    $section = AboutSection::create([
        'title' => 'Test About',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    AboutFeature::create(['about_section_id' => $section->id, 'title' => 'Feature 1', 'is_active' => true, 'sort_order' => 1]);
    AboutFeature::create(['about_section_id' => $section->id, 'title' => 'Feature 2', 'is_active' => true, 'sort_order' => 2]);

    expect($section->features()->count())->toBe(2);
});

test('AboutFeature belongs to AboutSection', function () {
    $section = AboutSection::create(['title' => 'Parent', 'is_active' => true, 'sort_order' => 1]);
    $feature = AboutFeature::create(['about_section_id' => $section->id, 'title' => 'Child', 'is_active' => true, 'sort_order' => 1]);

    expect($feature->section->id)->toBe($section->id);
});

// ─── Relasi PortfolioImage ────────────────────────────────────────────────────

test('Portfolio has many PortfolioImages', function () {
    $category = PortfolioCategory::create(['name' => 'Cat', 'is_active' => true, 'sort_order' => 1]);
    $portfolio = Portfolio::create([
        'title' => 'Test Portfolio',
        'portfolio_category_id' => $category->id,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    PortfolioImage::create(['portfolio_id' => $portfolio->id, 'image' => 'img1.jpg', 'sort_order' => 1]);
    PortfolioImage::create(['portfolio_id' => $portfolio->id, 'image' => 'img2.jpg', 'sort_order' => 2]);

    expect($portfolio->images()->count())->toBe(2);
});

test('PortfolioImage belongs to Portfolio', function () {
    $category = PortfolioCategory::create(['name' => 'Cat2', 'is_active' => true, 'sort_order' => 1]);
    $portfolio = Portfolio::create([
        'title' => 'Parent Portfolio',
        'portfolio_category_id' => $category->id,
        'is_active' => true,
        'sort_order' => 1,
    ]);
    $image = PortfolioImage::create(['portfolio_id' => $portfolio->id, 'image' => 'img.jpg', 'sort_order' => 1]);

    expect($image->portfolio->id)->toBe($portfolio->id);
});

// ─── Slug generation ─────────────────────────────────────────────────────────

test('Service generates slug from title on create', function () {
    $service = Service::create(['title' => 'Web Development', 'is_active' => true, 'sort_order' => 1]);

    expect($service->slug)->toBe('web-development');
});

test('Service slug is unique — appends counter on duplicate', function () {
    Service::create(['title' => 'Design', 'is_active' => true, 'sort_order' => 1]);
    $second = Service::create(['title' => 'Design', 'is_active' => true, 'sort_order' => 2]);

    expect($second->slug)->toBe('design-1');
});

test('PortfolioCategory generates slug from name on create', function () {
    $category = PortfolioCategory::create(['name' => 'Mobile Apps', 'is_active' => true, 'sort_order' => 1]);

    expect($category->slug)->toBe('mobile-apps');
});

test('Portfolio generates slug from title on create', function () {
    $category = PortfolioCategory::create(['name' => 'Web', 'is_active' => true, 'sort_order' => 1]);
    $portfolio = Portfolio::create([
        'title' => 'My Portfolio',
        'portfolio_category_id' => $category->id,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    expect($portfolio->slug)->toBe('my-portfolio');
});

// ─── InternalOrExternalUrl rule ───────────────────────────────────────────────

test('InternalOrExternalUrl passes for null and empty string', function () {
    $rule = new InternalOrExternalUrl;

    expect($rule->passes('url', null))->toBeTrue();
    expect($rule->passes('url', ''))->toBeTrue();
});

test('InternalOrExternalUrl passes for anchor links', function () {
    $rule = new InternalOrExternalUrl;

    expect($rule->passes('url', '#contact'))->toBeTrue();
    expect($rule->passes('url', '#hero'))->toBeTrue();
});

test('InternalOrExternalUrl passes for internal paths', function () {
    $rule = new InternalOrExternalUrl;

    expect($rule->passes('url', '/about'))->toBeTrue();
    expect($rule->passes('url', '/services/web'))->toBeTrue();
});

test('InternalOrExternalUrl passes for valid external URLs', function () {
    $rule = new InternalOrExternalUrl;

    expect($rule->passes('url', 'https://example.com'))->toBeTrue();
    expect($rule->passes('url', 'http://example.com/page'))->toBeTrue();
});

test('InternalOrExternalUrl fails for invalid strings', function () {
    $rule = new InternalOrExternalUrl;

    expect($rule->passes('url', 'not a url'))->toBeFalse();
    expect($rule->passes('url', 'ftp://bad'))->toBeFalse();
});

// ─── Cache invalidation ───────────────────────────────────────────────────────

test('LandingPageService caches hero slides', function () {
    $this->seed(LandingPageSeeder::class);

    Cache::flush();

    $slides = LandingPageService::getHeroSlides();

    expect(Cache::has('landing_page.hero'))->toBeTrue();
    expect($slides)->toHaveCount(2);
});

test('Cache is cleared when HeroSlide is created', function () {
    Cache::put('landing_page.hero', collect([]), 3600);
    Cache::put('landing_page.all', [], 3600);

    HeroSlide::create(['title' => 'New Slide', 'is_active' => true, 'sort_order' => 99]);

    expect(Cache::has('landing_page.hero'))->toBeFalse();
    expect(Cache::has('landing_page.all'))->toBeFalse();
});

test('Cache is cleared when HeroSlide is updated', function () {
    $slide = HeroSlide::create(['title' => 'Slide', 'is_active' => true, 'sort_order' => 1]);

    Cache::put('landing_page.hero', collect([]), 3600);

    $slide->update(['title' => 'Updated Slide']);

    expect(Cache::has('landing_page.hero'))->toBeFalse();
});

test('Cache is cleared when HeroSlide is deleted', function () {
    $slide = HeroSlide::create(['title' => 'Slide', 'is_active' => true, 'sort_order' => 1]);

    Cache::put('landing_page.hero', collect([]), 3600);

    $slide->delete();

    expect(Cache::has('landing_page.hero'))->toBeFalse();
});

// ─── Filament page access ─────────────────────────────────────────────────────

test('authenticated user can access Filament admin panel', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertSuccessful();
});

test('unauthenticated user is redirected from admin panel', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('authenticated user can access hero slides list page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/hero-slides')
        ->assertSuccessful();
});

test('authenticated user can access navigation items list page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/navigation-items')
        ->assertSuccessful();
});

test('authenticated user can access services list page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/services')
        ->assertSuccessful();
});

test('authenticated user can access portfolios list page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/portfolios')
        ->assertSuccessful();
});

test('authenticated user can access testimonials list page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/testimonials')
        ->assertSuccessful();
});

test('authenticated user can access landing page settings page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/landing-page-settings')
        ->assertSuccessful();
});

test('authenticated user can access call to action settings page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/call-to-action-settings')
        ->assertSuccessful();
});
