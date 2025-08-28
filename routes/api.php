<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintApiController;
use App\Http\Controllers\Auth\JwtAuthController;
use App\Http\Controllers\Auth\JwtPasswordResetController;
use Illuminate\Support\Facades\Route;

// JWT Authentication Routes
Route::controller(JwtAuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});

// Password Reset Routes
Route::controller(JwtPasswordResetController::class)->group(function () {
    Route::post('forgot-password', 'sendResetLink');
    Route::post('reset-password', 'resetPassword');
});

// Legacy API routes (keeping for compatibility)
Route::post('/login', [AuthController::class,'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/complaints', [ComplaintApiController::class,'index']);
    Route::get('/complaints/{complaint}', [ComplaintApiController::class,'show']);
});


