<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Artikel\Http\Controller\ArtikelController;

Route::middleware(['web', 'auth'])->prefix('admin/artikel')->group(function () {
    Route::get('/', [ArtikelController::class, 'indeks']);
    Route::get('/tambah', [ArtikelController::class, 'tambah']);
    Route::post('/tambah', [ArtikelController::class, 'simpan']);
    Route::get('/edit/{id}', [ArtikelController::class, 'edit']);
    Route::post('/edit/{id}', [ArtikelController::class, 'perbarui']);
    Route::post('/ai-bantu', [ArtikelController::class, 'aiBantu']);
    Route::post('/hapus/{id}', [ArtikelController::class, 'hapus']);
});
