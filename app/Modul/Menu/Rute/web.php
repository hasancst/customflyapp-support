<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Menu\Http\Controller\MenuController;

Route::middleware(['web', 'auth'])->prefix('admin/menu')->group(function () {
    Route::get('/', [MenuController::class, 'indeks']);
    Route::post('/', [MenuController::class, 'simpan']);
    Route::post('/ubah/{id}', [MenuController::class, 'perbarui']);
    Route::delete('/hapus/{id}', [MenuController::class, 'hapus']);
    Route::post('/urutan', [MenuController::class, 'urutan']);
});
