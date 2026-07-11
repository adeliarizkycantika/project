<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanMakanan extends Model
{
    use HasFactory;

    protected $table = 'bahan_makanan';

    protected $fillable = [
        'makanan_id',
        'nama',
        'nama_bahan',
        'name',
        'jumlah',
        'quantity',
        'qty',
        'satuan',
        'unit',
        'catatan',
        'note',
        'notes',
    ];

    protected $casts = [
        'jumlah' => 'float',
        'quantity' => 'float',
        'qty' => 'float',
    ];

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }

    public function getNamaLabelAttribute(): string
    {
        return $this->nama
            ?? $this->nama_bahan
            ?? $this->name
            ?? 'Bahan makanan';
    }

    public function getJumlahLabelAttribute(): string
    {
        $jumlah = $this->jumlah
            ?? $this->quantity
            ?? $this->qty
            ?? 1;

        $satuan = $this->satuan
            ?? $this->unit
            ?? 'pcs';

        return number_format((float) $jumlah, 1, ',', '.') . ' ' . $satuan;
    }

    public function getCatatanLabelAttribute(): string
    {
        return $this->catatan
            ?? $this->note
            ?? $this->notes
            ?? '';
    }
}