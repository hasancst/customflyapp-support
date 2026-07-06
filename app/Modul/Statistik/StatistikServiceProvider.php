<?php

namespace App\Modul\Statistik;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use App\Modul\Statistik\Http\Middleware\CatatPengunjung;

class StatistikServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel)
    {
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'statistik');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrasi');

        // Daftarkan middleware secara global untuk mencatat pengunjung frontend
        $kernel->prependMiddleware(CatatPengunjung::class);
    }
}
