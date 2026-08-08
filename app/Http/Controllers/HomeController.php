<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AboutBenefit;
use App\Models\Brand;
use App\Models\CompanyStatistic;
use App\Models\NavigationItem;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $settings = SiteSetting::instance();

        $navItems = NavigationItem::active()->ordered()->get();

        $statistics = CompanyStatistic::active()->ordered()->get();

        $benefits = AboutBenefit::active()->ordered()->get();

        $services = Service::active()->ordered()->get();

        // Featured projects untuk slider (semua is_featured = true)
        $featuredPortfolios = Portfolio::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->with('category')
            ->get();

        // Non-featured projects untuk Z-pattern list (max 4 di homepage)
        $otherQuery = Portfolio::where('is_active', true)->where('is_featured', false);
        $portfolios = $otherQuery->orderBy('sort_order')->with('category')->take(4)->get();
        $hasMorePortfolios = true;

        $testimonials = Testimonial::active()->ordered()->get();

        $brands = Brand::active()->ordered()->get();

        return view('home', compact(
            'settings',
            'navItems',
            'statistics',
            'benefits',
            'services',
            'featuredPortfolios',
            'portfolios',
            'hasMorePortfolios',
            'testimonials',
            'brands',
        ));
    }
}
