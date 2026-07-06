<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Video\Http\Controller\VideoController;

Route::prefix('admin/video')->middleware(['auth'])->group(function () {
    Route::get('/', [VideoController::class, 'indeks']);
    Route::get('/fetch', [VideoController::class, 'fetchInfo']);
    Route::get('/tambah', [VideoController::class, 'tambah']);
    Route::post('/simpan', [VideoController::class, 'simpan']);
    Route::get('/ubah/{id}', [VideoController::class, 'ubah']);
    Route::post('/perbarui/{id}', [VideoController::class, 'perbarui']);
    Route::get('/hapus/{id}', [VideoController::class, 'hapus']);
});
