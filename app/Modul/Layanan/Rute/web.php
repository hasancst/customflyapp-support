<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Layanan\Http\Controllers\LayananController;

Route::prefix('admin/layanan')->group(function () {
    Route::get('/', [LayananController::class, 'indeks']);
    Route::get('/tambah', [LayananController::class, 'tambah']);
    Route::post('/tambah', [LayananController::class, 'simpan']);
    Route::get('/ubah/{id}', [LayananController::class, 'ubah']);
    Route::post('/ubah/{id}', [LayananController::class, 'perbarui']);
    Route::post('/hapus/{id}', [LayananController::class, 'hapus']);
});
