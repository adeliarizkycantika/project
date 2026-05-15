<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MealPlan extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'tanggal_rencana',
        'catatan',
    ];

    protected $casts = [
        'tanggal_rencana' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MealPlanItem::class);
    }

    public function itemDaftarBelanja(): HasMany
    {
        return $this->hasMany(ItemDaftarBelanja::class);
    }
}