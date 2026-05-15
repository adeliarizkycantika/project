<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_makanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('makanan_id')
                ->constrained('makanan')
                ->cascadeOnDelete();

            $table->string('nama');
            $table->decimal('jumlah', 8, 2)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->timestamps();

            $table->index('makanan_id');
            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_makanan');
    }
};