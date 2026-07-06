<?php

namespace App\Modul\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'menu');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
    }
}
