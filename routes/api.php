<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\MobilController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\NotificationController;



Route::post('/fcm/send', [NotificationController::class, 'sendTest']);

Route::prefix('auth')->group(function () {
    Route::post('/request-otp', [AuthController::class, 'requestOTP']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/complete-profile', [AuthController::class, 'completeProfile']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/fcm-token', [AuthController::class, 'updateFCMToken']);

    Route::get('/mobil', [MobilController::class, 'index']);
    Route::get('/mobil/rekomendasi', [MobilController::class, 'rekomendasi']);
    Route::get('/mobil/{id}', [MobilController::class, 'show']);

    Route::post('/booking', [BookingController::class, 'store']);
    Route::post('/booking/{id}/upload-bukti', [BookingController::class, 'uploadBuktiPembayaran']);
    Route::get('/booking', [BookingController::class, 'myBookings']);
    Route::get('/booking/{id}', [BookingController::class, 'show']);
    Route::get('/booking/{id}/faktur', [BookingController::class, 'faktur']);

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/customers/pending', [AdminController::class, 'pendingCustomers']);
        Route::post('/customers/{userId}/verify', [AdminController::class, 'verifyCustomer']);

        Route::get('/payments/pending', [AdminController::class, 'pendingPayments']);
        Route::post('/bookings/{bookingId}/verify-payment', [AdminController::class, 'verifyPayment']);
        Route::post('/bookings/{bookingId}/update-status', [AdminController::class, 'updateBookingStatus']);
    });
});
