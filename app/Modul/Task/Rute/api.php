<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Task\Http\Controllers\Api\TaskApiController;

Route::middleware(['web', 'auth'])->prefix('v1/tasks')->group(function () {
    // Core CRUD
    Route::get('/', [TaskApiController::class, 'index']);
    Route::post('/', [TaskApiController::class, 'store']);
    Route::get('/{uuid}', [TaskApiController::class, 'show']);
    Route::put('/{uuid}', [TaskApiController::class, 'update']);
    Route::delete('/{uuid}', [TaskApiController::class, 'destroy']);

    // Actions
    Route::post('/{uuid}/assign', [TaskApiController::class, 'assign']);
    Route::post('/{uuid}/status', [TaskApiController::class, 'updateStatus']);
    Route::post('/generate-ai', [TaskApiController::class, 'generateFromAi']); // Manual trigger for AI analysis
});
