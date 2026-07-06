<?php

namespace App\Modul\SEO;

use Illuminate\Support\ServiceProvider;

class SEOServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Rute/web.php');
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'seo');
    }
}
