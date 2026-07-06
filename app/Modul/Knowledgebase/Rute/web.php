<?php

use Illuminate\Support\Facades\Route;
use App\Modul\Knowledgebase\Http\Controllers\KBAdminController;
use App\Modul\Knowledgebase\Http\Controllers\KBPublicController;

// Admin Routes
Route::prefix('admin/kb')->middleware(['web', 'auth'])->group(function () {
    // Categories
    Route::get('/category', [KBAdminController::class, 'indexCategory']);
    Route::post('/category', [KBAdminController::class, 'storeCategory']);
    Route::post('/category/update/{id}', [KBAdminController::class, 'updateCategory']);
    Route::post('/category/delete/{id}', [KBAdminController::class, 'deleteCategory']);
    
    // Articles
    Route::get('/article', [KBAdminController::class, 'indexArticle']);
    Route::get('/article/create', [KBAdminController::class, 'createArticle']);
    Route::post('/article/store', [KBAdminController::class, 'storeArticle']);
    Route::get('/article/edit/{id}', [KBAdminController::class, 'editArticle']);
    Route::post('/article/update/{id}', [KBAdminController::class, 'updateArticle']);
    Route::post('/article/delete/{id}', [KBAdminController::class, 'deleteArticle']);
    Route::post('/article/ai-bantu', [KBAdminController::class, 'aiBantu']);
});

// Public Routes
Route::prefix('kb')->middleware(['web'])->group(function () {
    Route::get('/', [KBPublicController::class, 'index']);
    Route::get('/category/{slug}', [KBPublicController::class, 'showCategory']);
    Route::post('/ai-assistant', [KBPublicController::class, 'aiAssistant']);
    Route::get('/{slug}', [KBPublicController::class, 'showArticle']);
});
