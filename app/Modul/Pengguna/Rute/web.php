<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Pengguna\Http\Controller\PenggunaController;

Route::middleware(['web', 'auth', 'cek_izin:kelola-pengguna'])->prefix('admin/pengguna')->group(function () {
    Route::get('/', [PenggunaController::class, 'indeks']);
    Route::get('/tambah', [PenggunaController::class, 'tambah']);
    Route::post('/tambah', [PenggunaController::class, 'simpan']);
    Route::get('/ubah/{id}', [PenggunaController::class, 'ubah']);
    Route::post('/ubah/{id}', [PenggunaController::class, 'perbarui']);
    Route::delete('/hapus/{id}', [PenggunaController::class, 'hapus']);
});
