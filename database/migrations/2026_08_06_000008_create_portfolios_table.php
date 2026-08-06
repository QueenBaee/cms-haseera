<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_category_id')->nullable()->constrained('portfolio_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('eyebrow')->nullable();
            $table->string('client_name')->nullable();
            $table->date('project_date')->nullable();
            $table->string('location')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('logo')->nullable();
            $table->string('project_url')->nullable();
            $table->string('button_text')->nullable();
            $table->json('technologies')->nullable();
            $table->string('layout_variant')->default('image_left');
            $table->string('image_fit')->default('cover');
            $table->string('content_alignment')->default('left');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('portfolio_category_id');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
