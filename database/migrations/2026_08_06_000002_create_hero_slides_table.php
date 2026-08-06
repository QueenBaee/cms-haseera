<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->string('highlighted_text')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('desktop_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('background_image')->nullable();
            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_url')->nullable();
            $table->boolean('primary_button_new_tab')->default(false);
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();
            $table->boolean('secondary_button_new_tab')->default(false);
            $table->string('content_alignment')->default('left');
            $table->string('vertical_alignment')->default('center');
            $table->unsignedTinyInteger('overlay_opacity')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('published_at');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
