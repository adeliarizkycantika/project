<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom standar daftar belanja secara aman.
     * Migration ini non-destruktif: hanya menambah kolom yang belum ada.
     */
    public function up(): void
    {
        $tableName = $this->getShoppingTableName();

        if (! $tableName) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (! Schema::hasColumn($tableName, 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->index();
            }

            if (! Schema::hasColumn($tableName, 'bahan_makanan_id')) {
                $table->unsignedBigInteger('bahan_makanan_id')->nullable()->index();
            }

            if (! Schema::hasColumn($tableName, 'tanggal_belanja')) {
                $table->date('tanggal_belanja')->nullable()->index();
            }

            if (! Schema::hasColumn($tableName, 'nama_item')) {
                $table->string('nama_item')->nullable();
            }

            if (! Schema::hasColumn($tableName, 'jumlah')) {
                $table->decimal('jumlah', 10, 2)->default(1);
            }

            if (! Schema::hasColumn($tableName, 'satuan')) {
                $table->string('satuan')->default('pcs');
            }

            if (! Schema::hasColumn($tableName, 'catatan')) {
                $table->text('catatan')->nullable();
            }

            if (! Schema::hasColumn($tableName, 'is_done')) {
                $table->boolean('is_done')->default(false);
            }
        });
    }

    /**
     * Sengaja tidak menghapus kolom agar tidak merusak struktur lama project.
     */
    public function down(): void
    {
        //
    }

    private function getShoppingTableName(): ?string
    {
        if (Schema::hasTable('item_daftar_belanjas')) {
            return 'item_daftar_belanjas';
        }

        if (Schema::hasTable('item_daftar_belanja')) {
            return 'item_daftar_belanja';
        }

        return null;
    }
};