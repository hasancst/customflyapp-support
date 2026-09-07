<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Muat Modul
        $loader = new \App\Inti\ModuleLoader();
        $loader->muatSemua();

        // Muat Tema
        $themeManager = new \App\Inti\ThemeManager();
        $themeManager->registrasiLokasiView();

        // Konfigurasi Email Dinamis dari Database Pengaturan
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('pengaturan')) {
                $mailSettings = \Illuminate\Support\Facades\DB::table('pengaturan')
                    ->whereIn('kunci', [
                        'mail_driver', 'mail_host', 'mail_port', 'mail_username',
                        'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name'
                    ])
                    ->pluck('nilai', 'kunci')
                    ->toArray();

                $driver = $mailSettings['mail_driver'] ?? null;
                if (!empty($driver)) {
                    config(['mail.default' => $driver]);

                    if ($driver === 'smtp') {
                        $port = (int)($mailSettings['mail_port'] ?? 587);
                        $encryption = $mailSettings['mail_encryption'] ?? 'tls';
                        $scheme = ($encryption === 'ssl' || $port === 465) ? 'smtps' : null;

                        config([
                            'mail.mailers.smtp.host' => $mailSettings['mail_host'] ?? config('mail.mailers.smtp.host'),
                            'mail.mailers.smtp.port' => $port,
                            'mail.mailers.smtp.scheme' => $scheme,
                            'mail.mailers.smtp.username' => $mailSettings['mail_username'] ?? config('mail.mailers.smtp.username'),
                            'mail.mailers.smtp.password' => $mailSettings['mail_password'] ?? config('mail.mailers.smtp.password'),
                        ]);
                    }

                    if (!empty($mailSettings['mail_from_address'])) {
                        config([
                            'mail.from.address' => $mailSettings['mail_from_address'],
                            'mail.from.name' => $mailSettings['mail_from_name'] ?? config('app.name'),
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            // Abaikan jika database belum siap / migrasi
        }

        // Share Data Global ke View
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $pengaturan = \Illuminate\Support\Facades\DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
            $headerMenus = collect([]);
            $footerMenus = collect([]);
            $supportMenus = collect([]);
            
            if (\Illuminate\Support\Facades\Schema::hasTable('menus')) {
                $groupedMenus = \App\Modul\Menu\Model\Menu::with('children')
                    ->whereNull('parent_id')
                    ->orderBy('urutan')
                    ->get()
                    ->groupBy('posisi');
                
                $headerMenus = $groupedMenus->get('header', collect([]));
                $footerMenus = $groupedMenus->get('footer', collect([]));
                $supportMenus = $groupedMenus->get('support', collect([]));
            }

            $globalIklan = collect([]);
            if (\Illuminate\Support\Facades\Schema::hasTable('iklan')) {
                $globalIklan = \Illuminate\Support\Facades\DB::table('iklan')->where('aktif', true)->get()->groupBy('posisi');
            }
            
            $modulAktif = [];
            if (\Illuminate\Support\Facades\Schema::hasTable('modul')) {
                $modulAktif = \Illuminate\Support\Facades\DB::table('modul')->where('aktif', true)->pluck('slug')->toArray();
            }

            $view->with('pengaturan', $pengaturan);
            $view->with('menus', $headerMenus); // Tetap 'menus' untuk kompatibilitas header jika perlu, tapi lebih baik gunakan nama baru
            $view->with('headerMenus', $headerMenus);
            $view->with('footerMenus', $footerMenus);
            $view->with('supportMenus', $supportMenus);
            $view->with('globalIklan', $globalIklan);
            $view->with('modulAktif', $modulAktif);
        });
    }
}
