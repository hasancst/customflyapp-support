<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Statistik\Http\Controller\StatistikController;

Route::middleware(['web', 'auth'])->prefix('admin/statistik')->group(function () {
    Route::get('/', [StatistikController::class, 'indeks']);
});
