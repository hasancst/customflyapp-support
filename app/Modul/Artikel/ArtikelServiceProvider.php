<?php

namespace App\Modul\Artikel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ArtikelServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register logic here if needed
    }

    public function boot()
    {
        // Load Routes
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');

        // Load Migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');

        // Load Views
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'artikel');
    }
}
