<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyBridgeController;
use App\Http\Controllers\TiketUploadController;
use App\Modul\Tiket\Http\Controllers\TiketPublikController;
use App\Modul\Knowledgebase\Http\Controllers\KBApiController;
use App\Http\Controllers\Api\AuthApiController;

Route::prefix('shopify')->middleware('shopify_bridge')->group(function () {
    Route::post('/auth',       [ShopifyBridgeController::class, 'auth']);
    Route::post('/sync-trial', [ShopifyBridgeController::class, 'syncTrial']);

    // Tickets
    Route::get('/tickets',                          [TiketPublikController::class, 'index']);
    Route::post('/tickets',                         [TiketPublikController::class, 'store']);
    Route::get('/tickets/{id}',                     [TiketPublikController::class, 'show']);
    Route::post('/tickets/{id}/reply',              [TiketPublikController::class, 'reply']);
    Route::get('/tickets/{id}/attachments',         [TiketUploadController::class, 'index']);
    Route::post('/tickets/{id}/attachments',        [TiketUploadController::class, 'upload']);

    // Categories (sub-kategori dari parent tertentu, default: Customfly)
    Route::get('/categories',                       [TiketPublikController::class, 'categories']);

    // Knowledge Base
    Route::get('/kb',        [KBApiController::class, 'index']);
    Route::get('/kb/{slug}', [KBApiController::class, 'article']);
});

// Public auth routes
Route::post('/auth/login', [AuthApiController::class, 'login']);

// Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    Route::get('/auth/me',      [AuthApiController::class, 'me']);

    // Tickets
    Route::get('/tickets',               [\App\Http\Controllers\Api\TiketApiController::class, 'index']);
    Route::get('/tickets/{id}',          [\App\Http\Controllers\Api\TiketApiController::class, 'show']);
    Route::post('/tickets/{id}/reply',   [\App\Http\Controllers\Api\TiketApiController::class, 'reply']);
    Route::patch('/tickets/{id}/status', [\App\Http\Controllers\Api\TiketApiController::class, 'updateStatus']);

    // Chat
    Route::get('/chat/sessions',              [\App\Http\Controllers\Api\ChatApiController::class, 'activeSessions']);
    Route::get('/chat/sessions/{id}/messages',[\App\Http\Controllers\Api\ChatApiController::class, 'messages']);
    Route::post('/chat/sessions/{id}/send',   [\App\Http\Controllers\Api\ChatApiController::class, 'sendMessage']);
    Route::post('/chat/sessions/{id}/close',  [\App\Http\Controllers\Api\ChatApiController::class, 'closeSession']);

    // Tasks
    Route::get('/tasks',               [\App\Modul\Task\Http\Controllers\Api\TaskApiController::class, 'index']);
    Route::post('/tasks',              [\App\Modul\Task\Http\Controllers\Api\TaskApiController::class, 'store']);
    Route::get('/tasks/{uuid}',        [\App\Modul\Task\Http\Controllers\Api\TaskApiController::class, 'show']);
    Route::put('/tasks/{uuid}',        [\App\Modul\Task\Http\Controllers\Api\TaskApiController::class, 'update']);
    Route::delete('/tasks/{uuid}',     [\App\Modul\Task\Http\Controllers\Api\TaskApiController::class, 'destroy']);
    Route::post('/tasks/{uuid}/status',[\App\Modul\Task\Http\Controllers\Api\TaskApiController::class, 'updateStatus']);

    // News (Berita)
    Route::get('/news',          [\App\Http\Controllers\Api\ContentApiController::class, 'listNews']);
    Route::post('/news',         [\App\Http\Controllers\Api\ContentApiController::class, 'storeNews']);
    Route::get('/news/{id}',     [\App\Http\Controllers\Api\ContentApiController::class, 'showNews']);
    Route::patch('/news/{id}',   [\App\Http\Controllers\Api\ContentApiController::class, 'updateNews']);
    Route::delete('/news/{id}',  [\App\Http\Controllers\Api\ContentApiController::class, 'deleteNews']);

    // Articles (Artikel)
    Route::get('/articles',         [\App\Http\Controllers\Api\ContentApiController::class, 'listArticles']);
    Route::post('/articles',        [\App\Http\Controllers\Api\ContentApiController::class, 'storeArticle']);
    Route::get('/articles/{id}',    [\App\Http\Controllers\Api\ContentApiController::class, 'showArticle']);
    Route::patch('/articles/{id}',  [\App\Http\Controllers\Api\ContentApiController::class, 'updateArticle']);
    Route::delete('/articles/{id}', [\App\Http\Controllers\Api\ContentApiController::class, 'deleteArticle']);
});
