<?php

use App\Http\Controllers\AuthsController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;


Route::apiResource('products', ProductsController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('products', ProductsController::class)->only(['store', 'update', 'destroy']);
    Route::put('/promote/{user}', [AuthsController::class, 'promote']);
});

Route::post('/login', [AuthsController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthsController::class, 'logout']);
Route::post('/register', [AuthsController::class, 'register']);
Route::post('/forgot-password', [AuthsController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthsController::class, 'resetPassword']);

