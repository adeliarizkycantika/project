<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemDaftarBelanja extends Model
{
    protected $table = 'item_daftar_belanja';

    protected $fillable = [
        'user_id',
        'meal_plan_id',
        'bahan_makanan_id',
        'nama_item',
        'jumlah',
        'satuan',
        'sudah_dibeli',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'sudah_dibeli' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mealPlan(): BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }

    public function bahanMakanan(): BelongsTo
    {
        return $this->belongsTo(BahanMakanan::class, 'bahan_makanan_id');
    }
}