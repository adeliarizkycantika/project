<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('makanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_makanan_id')
                ->constrained('kategori_makanan')
                ->cascadeOnDelete();

            $table->string('nama');
            $table->text('deskripsi')->nullable();

            $table->unsignedInteger('kalori')->default(0);
            $table->decimal('protein', 8, 2)->default(0);
            $table->decimal('karbohidrat', 8, 2)->default(0);
            $table->decimal('lemak', 8, 2)->default(0);

            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->index('kategori_makanan_id');
            $table->index('nama');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('makanan');
    }
};