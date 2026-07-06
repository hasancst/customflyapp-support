<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Portofolio\Http\Controllers\PortofolioController;

Route::prefix('admin/portofolio')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [PortofolioController::class, 'indeks']);
    Route::get('/tambah', [PortofolioController::class, 'tambah']);
    Route::post('/tambah', [PortofolioController::class, 'simpan']);
    Route::get('/ubah/{id}', [PortofolioController::class, 'ubah']);
    Route::post('/ubah/{id}', [PortofolioController::class, 'perbarui']);
    Route::post('/hapus/{id}', [PortofolioController::class, 'hapus']);
});
