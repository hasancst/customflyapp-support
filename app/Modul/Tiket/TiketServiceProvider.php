<?php

namespace App\Modul\Tiket;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class TiketServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'tiket');
        
        Route::middleware(['web', 'auth'])
            ->group(__DIR__ . '/Rute/web.php');
    }

    public function register()
    {
        //
    }
}
