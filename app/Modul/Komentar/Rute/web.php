<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Komentar\Http\Controller\KomentarController;

Route::middleware(['web', 'auth'])->group(function () {
    // Admin Moderation
    Route::prefix('admin/komentar')->group(function () {
        Route::get('/', [KomentarController::class, 'indeks']);
        Route::post('/setujui/{id}', [KomentarController::class, 'setujui']);
        Route::post('/spam/{id}', [KomentarController::class, 'tandaiSpam']);
        Route::delete('/hapus/{id}', [KomentarController::class, 'hapus']);
    });

    // Public Submission
    Route::post('/komentar/kirim', [KomentarController::class, 'kirim'])->name('komentar.kirim');
});
