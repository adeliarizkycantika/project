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
        'recommendation_image_path',
    ];

    protected $appends = [
        'logo_url',
        'auth_background_url',
        'recommendation_image_url',
    ];

    /**
     * URL logo yang diunggah melalui Panel Admin.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->getPublicStorageUrl(
            $this->logo_path
        );
    }

    /**
     * URL background halaman login dan register.
     */
    public function getAuthBackgroundUrlAttribute(): ?string
    {
        return $this->getPublicStorageUrl(
            $this->auth_background_path
        );
    }

    /**
     * URL satu foto global untuk seluruh menu rekomendasi.
     */
    public function getRecommendationImageUrlAttribute(): ?string
    {
        return $this->getPublicStorageUrl(
            $this->recommendation_image_path
        );
    }

    /**
     * Mengubah path file pada disk public menjadi URL browser.
     */
    private function getPublicStorageUrl(
        ?string $storedPath
    ): ?string {
        $path = trim((string) $storedPath);

        if ($path === '') {
            return null;
        }

        if (! Storage::disk('public')->exists($path)) {
            return null;
        }

        return asset(
            'storage/' . ltrim($path, '/')
        );
    }

    /**
     * Mengambil satu record pengaturan website.
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
            'recommendation_image_path' => null,
        ]);
    }
}
