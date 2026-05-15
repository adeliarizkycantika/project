<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealPlanItem extends Model
{
    protected $fillable = [
        'meal_plan_id',
        'makanan_id',
        'waktu_makan',
        'porsi',
        'sudah_dikonsumsi',
        'dikonsumsi_pada',
        'catatan',
    ];

    protected $casts = [
        'porsi' => 'integer',
        'sudah_dikonsumsi' => 'boolean',
        'dikonsumsi_pada' => 'datetime',
    ];

    public function mealPlan(): BelongsTo
    {
        return $this->belongsTo(MealPlan::class);
    }

    public function makanan(): BelongsTo
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }

    public function getTotalKaloriAttribute(): int
    {
        if (! $this->makanan) {
            return 0;
        }

        return $this->makanan->kalori * $this->porsi;
    }
}