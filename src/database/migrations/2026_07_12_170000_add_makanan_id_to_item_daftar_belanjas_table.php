<?php

use App\Models\ItemDaftarBelanja;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = (new ItemDaftarBelanja())->getTable();

        if (! Schema::hasTable($tableName)) {
            return;
        }

        if (Schema::hasColumn($tableName, 'makanan_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table): void {
            $table
                ->foreignId('makanan_id')
                ->nullable()
                ->constrained('makanan')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        $tableName = (new ItemDaftarBelanja())->getTable();

        if (! Schema::hasTable($tableName)) {
            return;
        }

        if (! Schema::hasColumn($tableName, 'makanan_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table): void {
            $table->dropConstrainedForeignId('makanan_id');
        });
    }
};
