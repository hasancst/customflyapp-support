<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Faq\Http\Controllers\FaqController;

Route::prefix('admin/faq')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [FaqController::class, 'indeks']);
    Route::get('/tambah', [FaqController::class, 'tambah']);
    Route::post('/tambah', [FaqController::class, 'simpan']);
    Route::get('/ubah/{id}', [FaqController::class, 'ubah']);
    Route::post('/ubah/{id}', [FaqController::class, 'perbarui']);
    Route::post('/hapus/{id}', [FaqController::class, 'hapus']);
});
