<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanan';

    protected $fillable = [
        'user_id',
        'kategori_makanan_id',
        'nama',
        'deskripsi',
        'kalori',
        'protein',
        'karbohidrat',
        'lemak',
        'is_recommended',
        'is_public',
        'recommended_note',
    ];

    protected $casts = [
        'kalori' => 'integer',
        'protein' => 'float',
        'karbohidrat' => 'float',
        'lemak' => 'float',
        'is_recommended' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriMakanan()
    {
        return $this->belongsTo(KategoriMakanan::class, 'kategori_makanan_id');
    }

    public function kategori()
    {
        return $this->kategoriMakanan();
    }

    public function bahanMakanan()
    {
        return $this->hasMany(BahanMakanan::class, 'makanan_id');
    }

    public function bahanMakanans()
    {
        return $this->bahanMakanan();
    }

    public function mealPlanItems()
    {
        return $this->hasMany(MealPlanItem::class, 'makanan_id');
    }

    public function getNamaLengkapAttribute(): string
    {
        return $this->nama ?? 'Makanan tanpa nama';
    }

    public function getKaloriLabelAttribute(): string
    {
        return number_format((int) $this->kalori, 0, ',', '.') . ' kkal';
    }

    public function getNutritionSummaryAttribute(): string
    {
        return 'Protein ' . number_format((float) $this->protein, 1, ',', '.') . 'g'
            . ' • Karbo ' . number_format((float) $this->karbohidrat, 1, ',', '.') . 'g'
            . ' • Lemak ' . number_format((float) $this->lemak, 1, ',', '.') . 'g';
    }

    public function getRecommendationLabelAttribute(): string
    {
        return $this->is_recommended ? 'Direkomendasikan' : 'Biasa';
    }

    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
