<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Branding
            $table->string('site_name')->default('Haseera');
            $table->string('site_tagline')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('favicon')->nullable();

            // Company info
            $table->text('company_description')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            // Social media
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('tiktok_url')->nullable();

            // Footer
            $table->text('footer_text')->nullable();

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('og_image')->nullable();

            // Hero section
            $table->string('hero_badge')->nullable();
            $table->text('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_primary_button_text')->nullable();
            $table->string('hero_primary_button_url')->nullable();
            $table->string('hero_secondary_button_text')->nullable();
            $table->string('hero_secondary_button_url')->nullable();

            // About section
            $table->string('about_eyebrow')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();

            // Services section
            $table->string('services_eyebrow')->nullable();
            $table->string('services_title')->nullable();
            $table->text('services_description')->nullable();

            // Projects section
            $table->string('projects_eyebrow')->nullable();
            $table->string('projects_title')->nullable();
            $table->text('projects_description')->nullable();

            // Testimonials section
            $table->string('testimonials_eyebrow')->nullable();
            $table->string('testimonials_title')->nullable();
            $table->text('testimonials_description')->nullable();

            // Footer CTA
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
