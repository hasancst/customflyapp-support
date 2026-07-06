<?php

namespace App\Modul\Komentar;

use Illuminate\Support\ServiceProvider;

class KomentarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'komentar');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
    }
}
