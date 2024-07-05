<?php

namespace App\Providers\Filament;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\YearResource;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
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
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
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
            ->plugins([
                FilamentEditProfilePlugin::make()
                   ->slug('my-profile')
                   ->setTitle('My Profile')
                   ->setNavigationLabel('My Profile')
                   ->setNavigationGroup('Settings')
                   ->setIcon('heroicon-o-user-circle')
                   ->setSort(1)
            ])
            ->plugins([
                FilamentGeneralSettingsPlugin::make()
                    ->canAccess(fn() => auth()->user()->role_id > 0)
                    ->setSort(3)
                    ->setIcon('heroicon-o-cog')
                    ->setNavigationGroup('Settings')
                    ->setTitle('General Settings')
                    ->setNavigationLabel('General Settings'),
                ])
            ->plugins([
                EnvironmentIndicatorPlugin::make(),
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
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->plugins([
                QuickCreatePlugin::make()
                ->includes([
                    \App\Filament\Resources\UserResource::class,
                    \App\Filament\Resources\YearResource::class,
                    \App\Filament\Resources\TrainingResource::class,
                    \App\Filament\Resources\SubjectResource::class,
                    \App\Filament\Resources\RatingResource::class,
                ])
                ->rounded(false)
            ])
            ->plugins([
                OverlookPlugin::make()
            ])
            ->widgets([
                OverlookWidget::class
            ])
            ->plugins([
                FilamentApexChartsPlugin::make()
            ]);
    }
}
