<?php

use App\Http\Controllers\AuthsController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;


Route::apiResource('products', ProductsController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('products', ProductsController::class)->only(['store', 'update', 'destroy']);
});

Route::post('/login', [AuthsController::class, 'login']);
Route::post('/register', [AuthsController::class, 'register']);
Route::put('/promote/{user}', [AuthsController::class, 'promote']);
