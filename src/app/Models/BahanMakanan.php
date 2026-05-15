<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BahanMakanan extends Model
{
    protected $table = 'bahan_makanan';

    protected $fillable = [
        'makanan_id',
        'nama',
        'jumlah',
        'satuan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function makanan(): BelongsTo
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }
}