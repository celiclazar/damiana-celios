<?php

namespace App\Providers\Filament;

use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Celios\Core\Filament\CeliosPlugin;
use Celios\Core\Filament\Pages\Auth\EditProfile;
use Celios\Core\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $adminTheme = function_exists('setting') ? setting('admin_theme', 'ocean') : 'ocean';

        $themePalettes = [
            'ocean' => [
                'primary' => Color::hex('#4474bf'),
                'gray' => Color::Slate,
                'secondary' => Color::hex('#3f6654'),
                'success' => Color::hex('#088557'),
            ],
            'emerald' => [
                'primary' => Color::hex('#059669'),
                'gray' => Color::Zinc,
                'secondary' => Color::hex('#0284c7'),
                'success' => Color::hex('#16a34a'),
            ],
            'midnight' => [
                'primary' => Color::hex('#7c3aed'),
                'gray' => Color::Neutral,
                'secondary' => Color::hex('#d97706'),
                'success' => Color::hex('#10b981'),
            ],
        ];

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->databaseNotifications()
            ->login()
            ->brandName(fn () => function_exists('setting') ? setting('site_name', 'Celios CMS') : 'Celios CMS')
            ->favicon('favicon.ico')
            ->colors($themePalettes[$adminTheme] ?? $themePalettes['ocean'])
            ->font('Inter')
            ->darkMode(
                in_array($adminTheme, ['midnight', 'obsidian']),
                in_array($adminTheme, ['midnight', 'obsidian'])
            )
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn () => view('filament.hooks.theme-attribute')
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_START,
                fn () => view('filament.hooks.sidebar-header')
            )
            ->pages([
                Dashboard::class,
            ])
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                CeliosPlugin::make(),
                CuratorPlugin::make()
                    ->label(fn () => __('sidebar.media'))
                    ->pluralLabel(fn () => __('sidebar.media'))
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup(fn () => __('sidebar.group_content'))
                    ->navigationSort(4),
                FilamentShieldPlugin::make()
                    ->navigationGroup(fn () => __('sidebar.group_system'))
                    ->navigationIcon('heroicon-o-shield-check')
                    ->navigationSort(2),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->profile(EditProfile::class)
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('My Profile')
                    ->url(fn (): string => EditProfile::getUrl())
                    ->icon('heroicon-m-user-circle'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets');
    }
}
