<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('call_to_action_settings', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->string('highlighted_text')->nullable();
            $table->text('description')->nullable();
            $table->string('background_image')->nullable();
            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_url')->nullable();
            $table->boolean('primary_button_new_tab')->default(false);
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();
            $table->boolean('secondary_button_new_tab')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('call_to_action_settings');
    }
};
