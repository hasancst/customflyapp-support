<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Iklan\Http\Controller\IklanController;

Route::middleware(['web', 'auth'])->prefix('admin/iklan')->group(function () {
    Route::get('/', [IklanController::class, 'indeks']);
    Route::get('/tambah', [IklanController::class, 'tambah']);
    Route::post('/tambah', [IklanController::class, 'simpan']);
    Route::get('/ubah/{id}', [IklanController::class, 'ubah']);
    Route::post('/ubah/{id}', [IklanController::class, 'perbarui']);
    Route::delete('/hapus/{id}', [IklanController::class, 'hapus']);
});
