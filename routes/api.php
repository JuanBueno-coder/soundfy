<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Auth routes with prefix and controller grouping
Route::prefix('auth')->controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
   
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('logout', 'logout');
        Route::get('profile', 'profile');
    });
});