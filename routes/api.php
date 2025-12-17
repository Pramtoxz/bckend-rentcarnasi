<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\MobilController;


Route::prefix('auth')->group(function () {
    Route::post('/request-otp', [AuthController::class, 'requestOTP']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/complete-profile', [AuthController::class, 'completeProfile']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Mobil endpoints
    Route::get('/mobil', [MobilController::class, 'index']);
    Route::get('/mobil/{id}', [MobilController::class, 'show']);
});
