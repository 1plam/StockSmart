<?php

use App\Presentation\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('checkout/{orderId}', [CheckoutController::class, 'show'])
    ->name('checkout.show');

Route::post('checkout/{orderId}/discount', [CheckoutController::class, 'applyDiscount'])
    ->name('checkout.apply-discount');

Route::post('checkout/{orderId}/process', [CheckoutController::class, 'process'])
    ->name('checkout.process');
