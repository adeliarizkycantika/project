<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom catatan ke tabel bahan makanan.
     */
    public function up(): void
    {
        $tableName = $this->getBahanMakananTableName();

        if (! $tableName) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (! Schema::hasColumn($tableName, 'catatan')) {
                if (Schema::hasColumn($tableName, 'satuan')) {
                    $table->text('catatan')->nullable()->after('satuan');
                } else {
                    $table->text('catatan')->nullable();
                }
            }
        });
    }

    /**
     * Rollback kolom catatan.
     */
    public function down(): void
    {
        $tableName = $this->getBahanMakananTableName();

        if (! $tableName) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (Schema::hasColumn($tableName, 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }

    private function getBahanMakananTableName(): ?string
    {
        if (Schema::hasTable('bahan_makanan')) {
            return 'bahan_makanan';
        }

        if (Schema::hasTable('bahan_makanans')) {
            return 'bahan_makanans';
        }

        return null;
    }
};