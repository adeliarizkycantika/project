<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_subtitle',
        'logo_path',
        'auth_background_path',
    ];

    protected $appends = [
        'logo_url',
        'auth_background_url',
    ];

    /**
     * URL logo yang telah diunggah melalui admin.
     * Jika belum ada logo, hasilnya null.
     */
    public function getLogoUrlAttribute(): ?string
    {
        $path = trim((string) $this->logo_path);

        if ($path === '') {
            return null;
        }

        if (! Storage::disk('public')->exists($path)) {
            return null;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * URL background autentikasi yang diunggah melalui admin.
     * Jika belum ada background, hasilnya null.
     */
    public function getAuthBackgroundUrlAttribute(): ?string
    {
        $path = trim((string) $this->auth_background_path);

        if ($path === '') {
            return null;
        }

        if (! Storage::disk('public')->exists($path)) {
            return null;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * Ambil satu pengaturan website yang aktif.
     */
    public static function current(): self
    {
        $setting = static::query()
            ->orderBy('id')
            ->first();

        if ($setting instanceof self) {
            return $setting;
        }

        return new self([
            'site_name' => 'Pola Makan Sehat',
            'site_subtitle' => 'Meal Planner & Kalori Harian',
            'logo_path' => null,
            'auth_background_path' => null,
        ]);
    }
}