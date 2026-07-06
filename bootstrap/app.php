<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->command('app:backup-database')->daily();
    })
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/mlebu');
        
        $middleware->replace(\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class, \App\Http\Middleware\PreventRequestsDuringMaintenance::class);
        
        $middleware->preventRequestsDuringMaintenance(except: [
            '/mlebu',
            '/mlebu/*',
            '/keluar',
            '/admin',
            '/admin/*',
        ]);
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'cek_izin' => \App\Http\Middleware\CekIzin::class,
            'shopify_bridge' => \App\Http\Middleware\VerifyShopifyHmac::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
