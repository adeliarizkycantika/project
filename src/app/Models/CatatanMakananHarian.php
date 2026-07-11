<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanMakananHarian extends Model
{
    use HasFactory;

    protected $table = 'catatan_makanan_harians';

    protected $fillable = [
        'user_id',
        'makanan_id',
        'tanggal',
        'waktu_makan',
        'nama_makanan',
        'porsi',
        'kalori',
        'protein',
        'karbohidrat',
        'lemak',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'porsi' => 'float',
        'kalori' => 'integer',
        'protein' => 'float',
        'karbohidrat' => 'float',
        'lemak' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }

    public function getTotalKaloriAttribute(): int
    {
        return (int) round($this->kalori * $this->porsi);
    }

    public function getTotalProteinAttribute(): float
    {
        return (float) $this->protein * (float) $this->porsi;
    }

    public function getTotalKarbohidratAttribute(): float
    {
        return (float) $this->karbohidrat * (float) $this->porsi;
    }

    public function getTotalLemakAttribute(): float
    {
        return (float) $this->lemak * (float) $this->porsi;
    }

    public function getWaktuMakanLabelAttribute(): string
    {
        return match ($this->waktu_makan) {
            'sarapan' => 'Sarapan',
            'makan_siang' => 'Makan Siang',
            'makan_malam' => 'Makan Malam',
            'cemilan' => 'Cemilan',
            default => 'Makan',
        };
    }
}