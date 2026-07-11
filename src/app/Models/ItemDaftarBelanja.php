<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ItemDaftarBelanja extends Model
{
    use HasFactory;

    protected $table = 'item_daftar_belanja';

    protected $fillable = [
        'user_id',
        'meal_plan_id',
        'bahan_makanan_id',
        'tanggal_belanja',
        'nama_item',
        'nama',
        'name',
        'item',
        'jumlah',
        'quantity',
        'qty',
        'satuan',
        'unit',
        'catatan',
        'note',
        'notes',
        'is_done',
        'selesai',
        'status',
    ];

    protected $casts = [
        'tanggal_belanja' => 'date',
        'jumlah' => 'float',
        'quantity' => 'float',
        'qty' => 'float',
        'is_done' => 'boolean',
        'selesai' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (Schema::hasTable('item_daftar_belanja')) {
            $this->setTable('item_daftar_belanja');
        } elseif (Schema::hasTable('item_daftar_belanjas')) {
            $this->setTable('item_daftar_belanjas');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mealPlan()
    {
        return $this->belongsTo(MealPlan::class, 'meal_plan_id');
    }

    public function bahanMakanan()
    {
        return $this->belongsTo(BahanMakanan::class, 'bahan_makanan_id');
    }

    public function getNamaItemLabelAttribute(): string
    {
        return $this->nama_item
            ?? $this->nama
            ?? $this->name
            ?? $this->item
            ?? 'Item belanja';
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

    public function getIsDoneLabelAttribute(): bool
    {
        if ($this->is_done !== null) {
            return (bool) $this->is_done;
        }

        if ($this->selesai !== null) {
            return (bool) $this->selesai;
        }

        return in_array((string) $this->status, [
            'selesai',
            'done',
            'completed',
            'sudah',
        ], true);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_done_label ? 'Selesai' : 'Belum selesai';
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeDone($query)
    {
        $table = $this->getTable();

        if (Schema::hasColumn($table, 'is_done')) {
            return $query->where('is_done', true);
        }

        if (Schema::hasColumn($table, 'selesai')) {
            return $query->where('selesai', true);
        }

        if (Schema::hasColumn($table, 'status')) {
            return $query->whereIn('status', [
                'selesai',
                'done',
                'completed',
                'sudah',
            ]);
        }

        return $query;
    }

    public function scopePending($query)
    {
        $table = $this->getTable();

        if (Schema::hasColumn($table, 'is_done')) {
            return $query->where('is_done', false);
        }

        if (Schema::hasColumn($table, 'selesai')) {
            return $query->where('selesai', false);
        }

        if (Schema::hasColumn($table, 'status')) {
            return $query->whereIn('status', [
                'belum',
                'pending',
                'todo',
            ]);
        }

        return $query;
    }
}