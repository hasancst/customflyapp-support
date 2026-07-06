<?php

use Illuminate\Support\Facades\Route;
use App\Modul\SEO\Http\Controller\SEOController;

Route::middleware(['web', 'auth'])->prefix('admin/seo')->group(function () {
    Route::post('/periksa', [SEOController::class, 'periksa'])->name('admin.seo.periksa');
});
