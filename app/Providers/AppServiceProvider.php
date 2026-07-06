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
