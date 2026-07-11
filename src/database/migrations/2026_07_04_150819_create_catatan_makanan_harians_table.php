<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel catatan makanan harian untuk makanan tambahan
     * yang dikonsumsi user di luar meal plan.
     */
    public function up(): void
    {
        Schema::create('catatan_makanan_harians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
             * Sengaja tidak memakai constrained('makanans') supaya tidak error
             * jika tipe id tabel makanans berbeda.
             *
             * Kolom ini tetap bisa dipakai untuk relasi Laravel.
             */
            $table->unsignedBigInteger('makanan_id')->nullable();

            $table->date('tanggal');
            $table->string('waktu_makan')->default('sarapan');
            $table->string('nama_makanan');

            $table->decimal('porsi', 6, 2)->default(1);
            $table->unsignedInteger('kalori')->default(0);
            $table->decimal('protein', 8, 2)->default(0);
            $table->decimal('karbohidrat', 8, 2)->default(0);
            $table->decimal('lemak', 8, 2)->default(0);

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index('makanan_id');
            $table->index('tanggal');
            $table->index(['user_id', 'tanggal']);
        });
    }

    /**
     * Menghapus tabel catatan makanan harian.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_makanan_harians');
    }
};