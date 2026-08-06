<?php

declare(strict_types=1);

namespace App\Providers;

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
use App\Observers\LandingPageCacheObserver;
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
        ] as $model) {
            $model::observe(LandingPageCacheObserver::class);
        }
    }
}
