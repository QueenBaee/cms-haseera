<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('logo_background')->default('auto')->after('logo');
            $table->unsignedSmallInteger('logo_scale')->default(100)->after('logo_background');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['logo_background', 'logo_scale']);
        });
    }
};
