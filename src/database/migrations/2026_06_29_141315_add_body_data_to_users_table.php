<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan data tubuh pengguna untuk kebutuhan perhitungan kalori harian.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('email');
            $table->unsignedTinyInteger('age')->nullable()->after('gender');
            $table->unsignedSmallInteger('height_cm')->nullable()->after('age');
            $table->decimal('weight_kg', 5, 2)->nullable()->after('height_cm');
            $table->string('activity_level')->nullable()->after('weight_kg');
        });
    }

    /**
     * Menghapus kolom data tubuh apabila migration di-rollback.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'age',
                'height_cm',
                'weight_kg',
                'activity_level',
            ]);
        });
    }
};