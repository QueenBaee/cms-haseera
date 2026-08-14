<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = [
        'site_name', 'site_tagline', 'logo', 'logo_dark', 'favicon', 'background_image', 'button_color',
        'company_description', 'phone', 'whatsapp', 'email', 'address', 'google_maps_url',
        'instagram_url', 'facebook_url', 'youtube_url', 'linkedin_url', 'tiktok_url',
        'footer_text',
        'seo_title', 'seo_description', 'seo_keywords', 'og_image',
        'hero_badge', 'hero_title', 'hero_description',
        'hero_primary_button_text', 'hero_primary_button_url',
        'hero_secondary_button_text', 'hero_secondary_button_url',
        'about_eyebrow', 'about_title', 'about_description',
        'services_eyebrow', 'services_title', 'services_description', 'services_columns',
        'projects_eyebrow', 'projects_title', 'projects_description',
        'testimonials_eyebrow', 'testimonials_title', 'testimonials_description',
        'cta_title', 'cta_description', 'cta_button_text', 'cta_button_url',
        'contact_badge', 'contact_title', 'contact_description',
        'contact_form_title', 'contact_quick_title', 'contact_quick_description',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'site_name' => 'Haseera',
        ]);
    }
}
