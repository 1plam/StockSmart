<?php

use App\Presentation\Http\Controllers\{CheckoutController, OrderController, ProductController, UserController};
use Illuminate\Support\Facades\Route;

// No authenticated routes due to restriction of installing packages, e.g. Sanctum needed for Token management.

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::post('/', [OrderController::class, 'store']);
    Route::put('/{id}', [OrderController::class, 'update']);
    Route::patch('/{id}/status', [OrderController::class, 'updateStatus']);
    Route::delete('/{id}', [OrderController::class, 'destroy']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::get('/profile', [UserController::class, 'profile']);
