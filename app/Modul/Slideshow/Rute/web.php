<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Slideshow\Http\Controller\SlideshowController;

Route::prefix('admin/slideshow')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [SlideshowController::class, 'indeks']);
    Route::get('/tambah', [SlideshowController::class, 'tambah']);
    Route::post('/tambah', [SlideshowController::class, 'simpan']);
    Route::get('/ubah/{id}', [SlideshowController::class, 'ubah']);
    Route::post('/ubah/{id}', [SlideshowController::class, 'perbarui']);
    Route::post('/hapus/{id}', [SlideshowController::class, 'hapus']);
});
