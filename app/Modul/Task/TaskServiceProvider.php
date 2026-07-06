<?php

namespace App\Modul\Task;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class TaskServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'task');
        
        // Register API Routes
        Route::middleware('api')
             ->group(__DIR__ . '/Rute/api.php');
             
        // Register Web Routes
        Route::middleware(['web', 'auth'])
             ->group(__DIR__ . '/Rute/web.php');
    }

    public function register()
    {
        //
    }
}
