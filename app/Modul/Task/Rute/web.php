<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Task\Http\Controllers\TaskController;

Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
   Route::get('/task', [TaskController::class, 'index']);
   Route::get('/task/{uuid}', [TaskController::class, 'show']);
});
