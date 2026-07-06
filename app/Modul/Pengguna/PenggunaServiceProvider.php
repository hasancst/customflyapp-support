<?php

namespace App\Modul\Pengguna;

use Illuminate\Support\ServiceProvider;

class PenggunaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'pengguna');
    }
}
