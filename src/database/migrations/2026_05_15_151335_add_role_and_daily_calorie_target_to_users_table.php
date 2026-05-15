<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'user'])
                    ->default('user')
                    ->after('password');
            }

            if (! Schema::hasColumn('users', 'daily_calorie_target')) {
                $table->unsignedInteger('daily_calorie_target')
                    ->default(2000)
                    ->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'daily_calorie_target')) {
                $table->dropColumn('daily_calorie_target');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};