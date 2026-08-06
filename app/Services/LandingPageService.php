<?php

declare(strict_types=1);

namespace App\Services;

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
use Illuminate\Support\Facades\Cache;

class LandingPageService
{
    public const CACHE_TTL = 3600;

    public static function getSettings(): ?LandingPageSetting
    {
        return Cache::remember('landing_page.settings', self::CACHE_TTL, function () {
            return LandingPageSetting::query()->first();
        });
    }

    public static function getNavigationItems(): iterable
    {
        return Cache::remember('landing_page.navigation', self::CACHE_TTL, function () {
            return NavigationItem::active()->ordered()->get();
        });
    }

    public static function getHeaderNavigation(): iterable
    {
        return self::getNavigationItems()->filter(function (NavigationItem $item) {
            return in_array($item->navigation_location, ['header', 'both'], true);
        })->values();
    }

    public static function getFooterNavigation(): iterable
    {
        return self::getNavigationItems()->filter(function (NavigationItem $item) {
            return in_array($item->navigation_location, ['footer', 'both'], true);
        })->values();
    }

    public static function getHeroSlides(): iterable
    {
        return Cache::remember('landing_page.hero', self::CACHE_TTL, function () {
            return HeroSlide::published()->ordered()->get();
        });
    }

    public static function getStatistics(): iterable
    {
        return Cache::remember('landing_page.statistics', self::CACHE_TTL, function () {
            return CompanyStatistic::active()->ordered()->get();
        });
    }

    public static function getAboutSections(): iterable
    {
        return Cache::remember('landing_page.about', self::CACHE_TTL, function () {
            return AboutSection::active()->ordered()->with(['features' => function ($query) {
                $query->active()->ordered();
            }])->get();
        });
    }

    public static function getServices(): iterable
    {
        return Cache::remember('landing_page.services', self::CACHE_TTL, function () {
            return Service::active()->ordered()->get();
        });
    }

    public static function getPortfolioCategories(): iterable
    {
        return Cache::remember('landing_page.portfolio_categories', self::CACHE_TTL, function () {
            return PortfolioCategory::active()->ordered()->withCount('portfolios')->get();
        });
    }

    public static function getPortfolios(): iterable
    {
        return Cache::remember('landing_page.portfolios', self::CACHE_TTL, function () {
            return Portfolio::active()->ordered()->with(['category', 'images'])->get();
        });
    }

    public static function getTestimonials(): iterable
    {
        return Cache::remember('landing_page.testimonials', self::CACHE_TTL, function () {
            return Testimonial::active()->ordered()->get();
        });
    }

    public static function getCallToAction(): ?CallToActionSetting
    {
        return Cache::remember('landing_page.cta', self::CACHE_TTL, function () {
            return CallToActionSetting::query()->first();
        });
    }

    public static function getSocialMediaLinks(): iterable
    {
        return Cache::remember('landing_page.social_media', self::CACHE_TTL, function () {
            return SocialMediaLink::active()->ordered()->get();
        });
    }

    public static function getLandingPageData(): array
    {
        return Cache::remember('landing_page.all', self::CACHE_TTL, function () {
            return [
                'settings' => self::getSettings(),
                'header_navigation' => self::getHeaderNavigation(),
                'footer_navigation' => self::getFooterNavigation(),
                'hero_slides' => self::getHeroSlides(),
                'statistics' => self::getStatistics(),
                'about_sections' => self::getAboutSections(),
                'services' => self::getServices(),
                'portfolio_categories' => self::getPortfolioCategories(),
                'portfolios' => self::getPortfolios(),
                'testimonials' => self::getTestimonials(),
                'cta' => self::getCallToAction(),
                'social_media_links' => self::getSocialMediaLinks(),
            ];
        });
    }

    public static function clearAllCache(): void
    {
        self::forgetSection('settings');
        self::forgetSection('navigation');
        self::forgetSection('hero');
        self::forgetSection('statistics');
        self::forgetSection('about');
        self::forgetSection('services');
        self::forgetSection('portfolio_categories');
        self::forgetSection('portfolios');
        self::forgetSection('testimonials');
        self::forgetSection('cta');
        self::forgetSection('social_media');
        self::forgetSection('all');
    }

    public static function forgetSection(string $section): void
    {
        Cache::forget(sprintf('landing_page.%s', $section));
    }
}
