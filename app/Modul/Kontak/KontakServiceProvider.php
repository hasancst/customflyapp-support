<?php

namespace App\Modul\Kontak;

use Illuminate\Support\ServiceProvider;

class KontakServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'kontak');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
    }
}
