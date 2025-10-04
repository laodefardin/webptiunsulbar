<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Menggunakan try-catch adalah praktik yang baik jika database belum dimigrasi
        try {
            // Mengambil menu utama
            $mainNav = Menu::where('location', 'main_nav')->with('menuItems.children')->first();

            // Mengambil menu top bar
            $topNav = Menu::where('location', 'top_nav')->with('menuItems')->first();

            // Mengirim data kedua menu ke view partials._header
            View::composer('partials._header', function ($view) use ($mainNav, $topNav) {
                $view->with('mainNavItems', $mainNav ? $mainNav->menuItems : collect());
                $view->with('topNavItems', $topNav ? $topNav->menuItems : collect());
            });
        } catch (\Exception $e) {
            // Jika terjadi error (misalnya tabel belum ada), kirim koleksi kosong
            View::composer('partials._header', function ($view) {
                $view->with('mainNavItems', collect());
                $view->with('topNavItems', collect());
            });
        }
    }
}
