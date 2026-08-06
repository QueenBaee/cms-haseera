<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\AboutSection;
use App\Models\CallToActionSetting;
use App\Models\CompanyStatistic;
use App\Models\HeroSlide;
use App\Models\LandingPageSetting;
use App\Models\NavigationItem;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Service;
use App\Models\SocialMediaLink;
use App\Models\Testimonial;
use App\Policies\AboutSectionPolicy;
use App\Policies\CallToActionSettingPolicy;
use App\Policies\CompanyStatisticPolicy;
use App\Policies\HeroSlidePolicy;
use App\Policies\LandingPageSettingPolicy;
use App\Policies\NavigationItemPolicy;
use App\Policies\PortfolioCategoryPolicy;
use App\Policies\PortfolioPolicy;
use App\Policies\ServicePolicy;
use App\Policies\SocialMediaLinkPolicy;
use App\Policies\TestimonialPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        LandingPageSetting::class => LandingPageSettingPolicy::class,
        NavigationItem::class => NavigationItemPolicy::class,
        HeroSlide::class => HeroSlidePolicy::class,
        CompanyStatistic::class => CompanyStatisticPolicy::class,
        AboutSection::class => AboutSectionPolicy::class,
        Service::class => ServicePolicy::class,
        PortfolioCategory::class => PortfolioCategoryPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
        Testimonial::class => TestimonialPolicy::class,
        CallToActionSetting::class => CallToActionSettingPolicy::class,
        SocialMediaLink::class => SocialMediaLinkPolicy::class,
    ];
}
