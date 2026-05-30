<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_daftar_belanja', function (Blueprint $table) {
            if (! Schema::hasColumn('item_daftar_belanja', 'tanggal_belanja')) {
                $table->date('tanggal_belanja')
                    ->nullable()
                    ->after('meal_plan_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('item_daftar_belanja', function (Blueprint $table) {
            if (Schema::hasColumn('item_daftar_belanja', 'tanggal_belanja')) {
                $table->dropColumn('tanggal_belanja');
            }
        });
    }
};