<?php

namespace App\Modul\Chat;

use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'chat');
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
    }

    public function register()
    {
        //
    }
}
