<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom rekomendasi pada tabel makanan.
     */
    public function up(): void
    {
        if (! Schema::hasTable('makanan')) {
            return;
        }

        Schema::table('makanan', function (Blueprint $table) {
            if (! Schema::hasColumn('makanan', 'is_recommended')) {
                $table->boolean('is_recommended')->default(false);
            }

            if (! Schema::hasColumn('makanan', 'is_public')) {
                $table->boolean('is_public')->default(true);
            }

            if (! Schema::hasColumn('makanan', 'recommended_note')) {
                $table->text('recommended_note')->nullable();
            }
        });
    }

    /**
     * Menghapus kolom rekomendasi dari tabel makanan.
     */
    public function down(): void
    {
        if (! Schema::hasTable('makanan')) {
            return;
        }

        Schema::table('makanan', function (Blueprint $table) {
            if (Schema::hasColumn('makanan', 'recommended_note')) {
                $table->dropColumn('recommended_note');
            }

            if (Schema::hasColumn('makanan', 'is_public')) {
                $table->dropColumn('is_public');
            }

            if (Schema::hasColumn('makanan', 'is_recommended')) {
                $table->dropColumn('is_recommended');
            }
        });
    }
};