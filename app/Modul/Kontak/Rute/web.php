<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Kontak\Http\Controller\KontakController;

Route::middleware(['web'])->group(function () {
    // Rute Admin
    Route::middleware(['auth'])->prefix('admin/kontak')->group(function () {
        Route::get('/', [KontakController::class, 'indeks']);
        Route::get('/{id}', [KontakController::class, 'detail'])->where('id', '[0-9]+');
        Route::delete('/{id}', [KontakController::class, 'hapus']);
    });

    // Rute Publik (Frontend)
    Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');
});
