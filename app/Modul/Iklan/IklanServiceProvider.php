<?php

namespace App\Modul\Iklan;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class IklanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load Migrasi
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');

        // Load View
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'iklan');

        // Load Routes
        $this->loadRoutes();
    }

    protected function loadRoutes()
    {
        Route::middleware('web')
            ->group(__DIR__ . '/Rute/web.php');
    }
}
