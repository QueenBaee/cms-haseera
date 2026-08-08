<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('contact_badge')->nullable()->after('cta_button_url');
            $table->string('contact_title')->nullable()->after('contact_badge');
            $table->text('contact_description')->nullable()->after('contact_title');
            $table->string('contact_form_title')->nullable()->after('contact_description');
            $table->string('contact_quick_title')->nullable()->after('contact_form_title');
            $table->text('contact_quick_description')->nullable()->after('contact_quick_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'contact_badge',
                'contact_title',
                'contact_description',
                'contact_form_title',
                'contact_quick_title',
                'contact_quick_description',
            ]);
        });
    }
};
