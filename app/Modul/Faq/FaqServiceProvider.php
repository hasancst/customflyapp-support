<?php

namespace App\Modul\Faq;

use Illuminate\Support\ServiceProvider;

class FaqServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'faq');
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
    }

    public function register()
    {
        //
    }
}
