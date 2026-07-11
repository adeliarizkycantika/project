<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            $table->string('site_name')
                ->default('Pola Makan Sehat');

            $table->string('site_subtitle')
                ->default('Meal Planner & Kalori Harian');

            $table->string('logo_path')
                ->nullable();

            $table->string('auth_background_path')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};