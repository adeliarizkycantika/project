<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriMakanan extends Model
{
    protected $table = 'kategori_makanan';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    public function makanan(): HasMany
    {
        return $this->hasMany(Makanan::class, 'kategori_makanan_id');
    }
}