<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\AboutBenefit;
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
use App\Models\SiteSetting;
use App\Models\SocialMediaLink;
use App\Models\Testimonial;
use App\Observers\LandingPageCacheObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact', function (Request $request): Limit {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });

        foreach ([
            LandingPageSetting::class,
            NavigationItem::class,
            HeroSlide::class,
            CompanyStatistic::class,
            AboutSection::class,
            AboutFeature::class,
            Service::class,
            PortfolioCategory::class,
            Portfolio::class,
            PortfolioImage::class,
            Testimonial::class,
            CallToActionSetting::class,
            SocialMediaLink::class,
            SiteSetting::class,
            AboutBenefit::class,
        ] as $model) {
            $model::observe(LandingPageCacheObserver::class);
        }
    }
}
