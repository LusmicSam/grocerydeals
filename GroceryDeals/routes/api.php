<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\DealApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);
Route::get('/deals', [DealApiController::class, 'index']);
Route::get('/categories', [CategoryApiController::class, 'index']);

// MongoDB Specific Features Demo Route
Route::post('/products/{id}/features', [ProductApiController::class, 'mongodbFeatures']);

// Protected Routes (Auth Required)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderApiController::class, 'store']);
    Route::get('/orders', [OrderApiController::class, 'index']);
    
    // CRUD for Products via API (Admin typically)
    Route::post('/products', [ProductApiController::class, 'store']);
    Route::put('/products/{id}', [ProductApiController::class, 'update']);
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);
});
