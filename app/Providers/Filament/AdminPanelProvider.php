<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\ThemesPlugin;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Navigation\NavigationGroup;
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
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->authGuard('web') // ✅ penting agar user dari guard web dikenali
            ->favicon(url('settings/01K6JA6M24GF5W0XHHP27Z1F17.png'))
            ->brandLogo(fn() => view('filament.admin.brand'))
            ->brandName(fn() => view('filament.admin.brand-name'))
            ->colors([
                'primary' => Color::Red, // warna tema utama
            ])
            ->profile() // aktifkan profil user di sidebar
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
                SetTheme::class, // pastikan ini di paling bawah
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('Konten Utama')->label('Konten Utama'),
                NavigationGroup::make('Struktur Website')->label('Struktur Website'),
                NavigationGroup::make('Data Master')->label('Data Master'),
                NavigationGroup::make('Pengaturan')->label('Pengaturan'),
            ])
            ->plugins([
                ThemesPlugin::make(),
            ]);
    }

    public function boot(): void
    {
        try {
            $settings = Setting::all()->pluck('value', 'key');

            View::composer(['filament.admin.brand', 'filament.admin.brand-name'], function ($view) use ($settings) {
                $logoPath = $settings['site_logo'] ?? null;
                $view->with('logoUrl', $logoPath ? Storage::url($logoPath) : null);
                $view->with('brandName', $settings['program_study_name'] ?? 'Admin Panel');
            });
        } catch (\Exception $e) {
            View::composer(['filament.admin.brand', 'filament.admin.brand-name'], function ($view) {
                $view->with('logoUrl', null);
                $view->with('brandName', 'Admin Panel');
            });
        }
    }

    public function canAccessPanel(Authenticatable $user): bool
    {
        // ✅ Untuk sekarang, izinkan semua user login mengakses panel admin
        return true;

        // Contoh: batasi hanya user tertentu
        // return in_array($user->email, ['admin@ptiunsulbar.ac.id']);
    }
}
