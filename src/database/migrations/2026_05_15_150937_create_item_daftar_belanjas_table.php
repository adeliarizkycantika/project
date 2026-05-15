<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_daftar_belanja', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('meal_plan_id')
                ->nullable()
                ->constrained('meal_plans')
                ->nullOnDelete();

            $table->foreignId('bahan_makanan_id')
                ->nullable()
                ->constrained('bahan_makanan')
                ->nullOnDelete();

            $table->string('nama_item');
            $table->decimal('jumlah', 8, 2)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->boolean('sudah_dibeli')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'meal_plan_id']);
            $table->index('bahan_makanan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_daftar_belanja');
    }
};