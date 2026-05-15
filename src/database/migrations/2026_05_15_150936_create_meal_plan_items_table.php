<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_plan_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('meal_plan_id')
                ->constrained('meal_plans')
                ->cascadeOnDelete();

            $table->foreignId('makanan_id')
                ->constrained('makanan')
                ->cascadeOnDelete();

            $table->enum('waktu_makan', [
                'sarapan',
                'makan_siang',
                'makan_malam',
                'snack',
            ]);

            $table->unsignedInteger('porsi')->default(1);
            $table->boolean('sudah_dikonsumsi')->default(false);
            $table->timestamp('dikonsumsi_pada')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['meal_plan_id', 'waktu_makan']);
            $table->index('makanan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_plan_items');
    }
};