<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\NavigationItem;
use App\Models\Portfolio;
use App\Models\SiteSetting;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::instance();

        $navItems = NavigationItem::active()->ordered()->get();

        $portfolios = Portfolio::where('is_active', true)
            ->with('category')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('portfolio.index', compact('settings', 'navItems', 'portfolios'));
    }
}
