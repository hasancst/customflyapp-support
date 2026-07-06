<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Tiket\Http\Controllers\TiketController;
use App\Modul\Tiket\Http\Controllers\TiketKategoriController;

Route::prefix('admin/tiket')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [TiketController::class, 'indeks']);
    Route::get('/tambah', [TiketController::class, 'tambah']);
    Route::post('/tambah', [TiketController::class, 'simpan']);
    Route::get('/detail/{id}', [TiketController::class, 'detail']);
    Route::post('/balas/{id}', [TiketController::class, 'balas']);
    Route::post('/status/{id}', [TiketController::class, 'gantiStatus']);
    Route::post('/hapus/{id}', [TiketController::class, 'hapus']);

    // Category Routes
    Route::get('/kategori', [TiketKategoriController::class, 'index']);
    Route::post('/kategori', [TiketKategoriController::class, 'store']);
    Route::post('/kategori/update/{id}', [TiketKategoriController::class, 'update']);
    Route::post('/kategori/hapus/{id}', [TiketKategoriController::class, 'delete']);
});
