<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyBridgeController;
use App\Http\Controllers\TiketUploadController;
use App\Modul\Tiket\Http\Controllers\TiketPublikController;
use App\Modul\Knowledgebase\Http\Controllers\KBApiController;

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
