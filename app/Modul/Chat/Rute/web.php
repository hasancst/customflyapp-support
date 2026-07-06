<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Chat\Http\Controllers\ChatWidgetController;

// Public Chat Widget API
Route::prefix('api/chat')->group(function () {
    Route::post('/init', [ChatWidgetController::class, 'initSession']);
    Route::post('/message', [ChatWidgetController::class, 'sendMessage']);
    Route::get('/history/{sessionToken}', [ChatWidgetController::class, 'getHistory']);
    Route::post('/escalate', [ChatWidgetController::class, 'escalate']);
    Route::post('/end', [ChatWidgetController::class, 'endSession']);
});

// Admin Widget Management
Route::prefix('admin/chat')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [ChatWidgetController::class, 'index']);
    Route::post('/widget/create', [ChatWidgetController::class, 'createWidget']);
    Route::get('/sessions', [ChatWidgetController::class, 'listSessions']);
    
    // Agent API
    Route::get('/api/active-sessions', [ChatWidgetController::class, 'getAdminActiveSessions']);
    Route::get('/api/messages/{sessionId}', [ChatWidgetController::class, 'getAdminMessages']);
    Route::post('/api/message', [ChatWidgetController::class, 'sendAdminMessage']);
});
