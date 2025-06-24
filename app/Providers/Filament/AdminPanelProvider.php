<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
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
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->passwordReset()
            ->profile()
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
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                $user = Auth::user();
                if (!$user) return $builder;

                $groups = [];

                // Semua user dapat Dashboard
                $groups[] = NavigationGroup::make()->items([
                    NavigationItem::make('Dashboard')
                        ->icon('heroicon-o-home')
                        ->url(route('filament.admin.pages.dashboard'))
                        ->isActiveWhen(fn() => request()->routeIs('filament.admin.pages.dashboard')),
                ]);

                // Admin: akses penuh
                if ($user->role === 'admin') {
                    $groups[] = NavigationGroup::make('Manajemen')->items([
                        NavigationItem::make('User')
                            ->icon('heroicon-o-users')
                            ->url(route('filament.admin.resources.users.index')),
                        ]);

                    $groups[] = NavigationGroup::make('Data')->items([
                        NavigationItem::make('Faskes')
                            ->icon('heroicon-o-building-office')
                            ->url(route('filament.admin.resources.faskes.index')),
                        NavigationItem::make('Kabupaten/Kota')
                            ->icon('heroicon-o-map')
                            ->url(route('filament.admin.resources.kabkotas.index')),
                        NavigationItem::make('Provinsi')
                            ->icon('heroicon-o-globe-alt')
                            ->url(route('filament.admin.resources.provinsis.index')),
                        NavigationItem::make('Jenis Faskes')
                            ->icon('heroicon-o-rectangle-stack')
                            ->url(route('filament.admin.resources.jenis-faskes.index')),
                        NavigationItem::make('Kategori')
                            ->icon('heroicon-o-tag')
                            ->url(route('filament.admin.resources.kategoris.index')),
                        ]);
                }

                // Dokter: kelola data faskes
                if ($user->role === 'dokter') {
                    $groups[] = NavigationGroup::make('Data Saya')->items([
                        NavigationItem::make('Faskes')
                            ->icon('heroicon-o-building-office')
                            ->url(route('filament.admin.resources.faskes.index')),
                    ]);
                }

                // Pegawai: hanya melihat faskes
                if ($user->role === 'pegawai') {
                    $groups[] = NavigationGroup::make('Informasi')->items([
                        NavigationItem::make('Lihat Faskes')
                            ->icon('heroicon-o-eye')
                            ->url(route('filament.admin.resources.faskes.index')),
                    ]);
                }

                return $builder->groups($groups);
            });
    }
}
