<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HandlesMediaCleanup;
use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    use HandlesMediaCleanup;

    protected array $mediaFields = ['logo', 'logo_dark', 'favicon', 'default_og_image'];

    protected $table = 'landing_page_settings';

    protected $fillable = [
        'site_name',
        'company_name',
        'site_tagline',
        'company_description',
        'logo',
        'logo_dark',
        'favicon',
        'primary_email',
        'secondary_email',
        'phone',
        'whatsapp',
        'address',
        'google_maps_url',
        'footer_description',
        'copyright_text',
        'default_meta_title',
        'default_meta_description',
        'default_og_image',
        'show_header',
        'show_hero',
        'show_statistics',
        'show_about',
        'show_services',
        'show_portfolio',
        'show_testimonials',
        'show_cta',
        'show_footer',
        'statistics_eyebrow',
        'statistics_title',
        'statistics_description',
        'services_eyebrow',
        'services_title',
        'services_description',
        'portfolio_eyebrow',
        'portfolio_title',
        'portfolio_description',
        'testimonials_eyebrow',
        'testimonials_title',
        'testimonials_description',
    ];

    protected $casts = [
        'show_header' => 'boolean',
        'show_hero' => 'boolean',
        'show_statistics' => 'boolean',
        'show_about' => 'boolean',
        'show_services' => 'boolean',
        'show_portfolio' => 'boolean',
        'show_testimonials' => 'boolean',
        'show_cta' => 'boolean',
        'show_footer' => 'boolean',
    ];
}
