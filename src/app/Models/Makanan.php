<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Makanan extends Model
{
    protected $table = 'makanan';

    protected $fillable = [
        'kategori_makanan_id',
        'nama',
        'deskripsi',
        'kalori',
        'protein',
        'karbohidrat',
        'lemak',
        'gambar',
    ];

    protected $casts = [
        'kalori' => 'integer',
        'protein' => 'decimal:2',
        'karbohidrat' => 'decimal:2',
        'lemak' => 'decimal:2',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriMakanan::class, 'kategori_makanan_id');
    }

    public function bahanMakanan(): HasMany
    {
        return $this->hasMany(BahanMakanan::class, 'makanan_id');
    }

    public function mealPlanItems(): HasMany
    {
        return $this->hasMany(MealPlanItem::class, 'makanan_id');
    }
}