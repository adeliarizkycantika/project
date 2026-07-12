<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AuthAppearanceServiceProvider extends ServiceProvider
{
    /**
     * Register service aplikasi.
     */
    public function register(): void
    {
        //
    }

    /**
     * Mengirim pengaturan tampilan website ke Blade.
     */
    public function boot(): void
    {
        View::composer([
            'auth.*',
            'layouts.user',
            'livewire.user.*',
            'user.*',
        ], function ($view): void {
            $view->with(
                'siteSetting',
                $this->resolveSiteSetting()
            );
        });
    }

    /**
     * Mengambil pengaturan website dari database.
     */
    private function resolveSiteSetting(): SiteSetting
    {
        try {
            if (! Schema::hasTable('site_settings')) {
                return $this->defaultSetting();
            }

            return SiteSetting::current();
        } catch (Throwable $exception) {
            report($exception);

            return $this->defaultSetting();
        }
    }

    /**
     * Pengaturan cadangan ketika tabel belum tersedia
     * atau belum memiliki data.
     */
    private function defaultSetting(): SiteSetting
    {
        return new SiteSetting([
            'site_name' => 'Pola Makan Sehat',
            'site_subtitle' => 'Meal Planner & Kalori Harian',
            'logo_path' => null,
            'auth_background_path' => null,
            'recommendation_image_path' => null,
        ]);
    }
}