<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'recommendation_image_path')) {
                $table->string('recommendation_image_path')
                    ->nullable()
                    ->after('auth_background_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'recommendation_image_path')) {
                $table->dropColumn('recommendation_image_path');
            }
        });
    }
};