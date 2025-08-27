<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/complaints', [ComplaintApiController::class,'index']);
    Route::get('/complaints/{complaint}', [ComplaintApiController::class,'show']);
});


