<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Providers\Plugin\TypesPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $locals = getLocales();

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make())
            ->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make()->allowCreate())
            ->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make()->allowClearTranslations())
            ->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsSwitcherPlugin::make())
            ->plugin(\TomatoPHP\FilamentBrowser\FilamentBrowserPlugin::make())
            ->plugin( \Filament\SpatieLaravelTranslatablePlugin::make()->defaultLocales($locals))
            // ->plugin(\TomatoPHP\FilamentMenus\FilamentMenusPlugin::make())
            ->plugin(\TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin::make())
            ->plugin(\TomatoPHP\FilamentLocations\FilamentLocationsPlugin::make())
            ->plugin(TypesPlugin::make())
            ->plugin(\TomatoPHP\FilamentPlugins\FilamentPluginsPlugin::make())
            ->plugin(\TomatoPHP\FilamentWallet\FilamentWalletPlugin::make());
    }
}
