<?php

namespace App\Modul\Slideshow;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SlideshowServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load Migrasi
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');

        // Load View
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'slideshow');

        // Load Routes
        $this->loadRoutes();
    }

    protected function loadRoutes()
    {
        Route::middleware('web')
            ->group(__DIR__ . '/Rute/web.php');
    }
}
