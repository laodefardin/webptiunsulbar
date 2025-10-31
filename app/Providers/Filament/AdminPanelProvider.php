<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use App\Models\Setting;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\ThemesPlugin;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Filament\Navigation\NavigationGroup;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            // ->path('ptimanage')
            ->login()
            ->favicon(url('settings/01K6JA6M24GF5W0XHHP27Z1F17.png'))
            ->brandLogo(fn () => view('filament.admin.brand')) // <-- Menggunakan view kustom untuk logo
            ->brandName(fn () => view('filament.admin.brand-name')) // <-- Menggunakan view kustom untuk nama brand
            ->colors([
                'primary' => [
                    '50' => '#f3e6e6',
                    '100' => '#e7cccc',
                    '200' => '#dbb3b3',
                    '300' => '#cf9999',
                    '400' => '#c38080',
                    '500' => '#b76666',
                    '600' => '#ab4d4d',
                    '700' => '#9f3333',
                    '800' => '#931a1a',
                    '900' => '#8b0000',
                    '950' => '#4a0000',
                ],
            ])
            ->profile()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            // Tambahkan blok kode ini untuk mengatur urutan grup navigasi
            ->navigationGroups([
                NavigationGroup::make('Konten Utama')->label('Konten Utama'),
                NavigationGroup::make('Struktur Website')->label('Struktur Website'),
                NavigationGroup::make('Data Master')->label('Data Master'),
                NavigationGroup::make('Pengaturan')->label('Pengaturan'),
            ])

             ->plugin(
            ThemesPlugin::make()
            );
    }

public function boot(): void
{
    // Mengirim data pengaturan ke view brand
    try {
        $settings = Setting::all()->pluck('value', 'key');

View::composer(['filament.admin.brand', 'filament.admin.brand-name'], function ($view) use ($settings) {
    $logoPath = $settings['site_logo'] ?? null;
    $view->with('logoUrl', $logoPath ? Storage::url($logoPath) : null);
    $view->with('brandName', $settings['program_study_name'] ?? 'Admin Panel');
});

    } catch (\Exception $e) {
        View::composer('filament.admin.brand', 'filament.admin.brand-name', function ($view) {
            $view->with('logoUrl', null);
            $view->with('brandName', 'Admin Panel');
        });
    }
}
}
