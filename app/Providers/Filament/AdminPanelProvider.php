<?php

namespace App\Providers\Filament;

use App\Filament\Resources\AnimalTypeResource;
use App\Filament\Resources\BunkerResource;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ProducerResource;
use App\Filament\Resources\RawResource;
use App\Filament\Resources\RawTypeResource;
use App\Filament\Resources\ReceiptResource;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

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
            ->profile()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('')->items([
                        NavigationItem::make('Дашборд')
                            ->icon('heroicon-o-home')
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                            ->url(fn (): string => Dashboard::getUrl()),
                        // ...OrderResource::getNavigationItems(),
                        ...ReceiptResource::getNavigationItems(),
                        ...RawResource::getNavigationItems(),
                        ...RawTypeResource::getNavigationItems(),
                        ...AnimalTypeResource::getNavigationItems(),
                        ...ProducerResource::getNavigationItems(),
                        ...BunkerResource::getNavigationItems(),
                        ...ClientResource::getNavigationItems(),
                    ])->collapsible(false),
                    NavigationGroup::make('Административное управление')->items([
                        ...UserResource::getNavigationItems(),
                        ...RoleResource::getNavigationItems(),
                    ])->collapsible(false),
                ]);
            });
    }
}
