<?php

namespace App\Modul\Portofolio;

use Illuminate\Support\ServiceProvider;

class PortofolioServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'portofolio');
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
    }

    public function register()
    {
        //
    }
}
