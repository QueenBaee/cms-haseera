<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('company_name')->nullable();
            $table->string('site_tagline')->nullable();
            $table->text('company_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('favicon')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('secondary_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('address')->nullable();
            $table->string('google_maps_url')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('copyright_text')->nullable();
            $table->string('default_meta_title')->nullable();
            $table->text('default_meta_description')->nullable();
            $table->string('default_og_image')->nullable();
            $table->boolean('show_header')->default(true);
            $table->boolean('show_hero')->default(true);
            $table->boolean('show_statistics')->default(true);
            $table->boolean('show_about')->default(true);
            $table->boolean('show_services')->default(true);
            $table->boolean('show_portfolio')->default(true);
            $table->boolean('show_testimonials')->default(true);
            $table->boolean('show_cta')->default(true);
            $table->boolean('show_footer')->default(true);
            $table->string('statistics_eyebrow')->nullable();
            $table->string('statistics_title')->nullable();
            $table->text('statistics_description')->nullable();
            $table->string('services_eyebrow')->nullable();
            $table->string('services_title')->nullable();
            $table->text('services_description')->nullable();
            $table->string('portfolio_eyebrow')->nullable();
            $table->string('portfolio_title')->nullable();
            $table->text('portfolio_description')->nullable();
            $table->string('testimonials_eyebrow')->nullable();
            $table->string('testimonials_title')->nullable();
            $table->text('testimonials_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_settings');
    }
};
