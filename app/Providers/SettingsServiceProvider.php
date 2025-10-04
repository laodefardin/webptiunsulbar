<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Pastikan tabel settings ada sebelum menjalankan query
        if (Schema::hasTable('settings')) {
            $settings = Setting::all()->pluck('value', 'key');

            // Bagikan variabel 'settings' ke semua view
            view()->share('settings', $settings);
        }
    }
}
