<?php

namespace App\Modul\Berita;

use Illuminate\Support\ServiceProvider;

class BeritaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'berita');
    }
}
