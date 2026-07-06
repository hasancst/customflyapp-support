<?php

namespace App\Modul\Layanan;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LayananServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'layanan');
        
        Route::middleware(['web', 'auth'])
            ->group(__DIR__ . '/Rute/web.php');
    }
}
