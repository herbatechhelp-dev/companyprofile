<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // Ambil logo dan favicon dari SiteSetting
        $logo = $this->getLogoFromSiteSetting();
        $favicon = $this->getFaviconFromSiteSetting() ?: $logo;
        $companyName = env('APP_NAME', 'Admin Panel');

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->brandName($companyName)
            ->brandLogo($logo)
            ->brandLogoHeight('2rem')
            ->favicon($favicon)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    /**
     * Get logo from SiteSetting
     */
    private function getLogoFromSiteSetting()
    {
        try {
            // Coba ambil logo dari SiteSetting
            $siteSetting = \App\Models\SiteSetting::where('key', 'logo')->first();
            
            if ($siteSetting && $siteSetting->value) {
                // Jika logo ada di storage
                if (strpos($siteSetting->value, 'storage/') === 0) {
                    return '/' . $siteSetting->value;
                }
                
                // Jika logo adalah full URL
                if (filter_var($siteSetting->value, FILTER_VALIDATE_URL)) {
                    return $siteSetting->value;
                }
                
                // Jika logo path relative
                return '/storage/' . $siteSetting->value;
            }
        } catch (\Exception $e) {
            // Fallback jika error
        }

        // Fallback logo default
        return $this->getDefaultLogo();
    }

    /**
     * Get favicon from SiteSetting
     */
    private function getFaviconFromSiteSetting()
    {
        try {
            $siteSetting = \App\Models\SiteSetting::where('key', 'favicon')->first();
            
            if ($siteSetting && $siteSetting->value) {
                if (filter_var($siteSetting->value, FILTER_VALIDATE_URL)) {
                    return $siteSetting->value;
                }
                
                return '/storage/' . $siteSetting->value;
            }
        } catch (\Exception $e) {}

        return null;
    }

    /**
     * Create default logo jika tidak ada
     */
    private function getDefaultLogo()
    {
        $companyName = env('APP_NAME', 'Admin');
        $initial = strtoupper(substr($companyName, 0, 1));
        
        // Return SVG logo sebagai fallback
        return "data:image/svg+xml;base64," . base64_encode("
            <svg width='40' height='40' xmlns='http://www.w3.org/2000/svg'>
                <rect width='40' height='40' fill='#2E8B57' rx='8'/>
                <text x='20' y='25' text-anchor='middle' fill='white' font-family='Arial, sans-serif' font-size='16' font-weight='bold'>$initial</text>
            </svg>
        ");
    }
}