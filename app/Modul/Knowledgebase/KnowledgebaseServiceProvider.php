<?php

namespace App\Modul\Knowledgebase;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class KnowledgebaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'knowledgebase');
        
        Route::middleware(['web'])
            ->group(__DIR__ . '/Rute/web.php');
    }

    public function register()
    {
        //
    }
}
