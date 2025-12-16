<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\PelangganController;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\Web\CustomerController;

Route::middleware('guest')->group(function(){
    // Route::get('/register' ,[AuthController::class, 'FormRegister'])->name('register');
    // Route::post('/simpan-register', [AuthController::class, 'Register'])->name('register.proses');
    Route::get('/login', [AuthController::class, 'FormLogin'])->name('login');
    Route::post('/login-proses', [AuthController::class, 'Login'])->name('login.proses');
    
});


Route::middleware('auth')->group(function(){
    Route::get('/', function () {
    return view('admin.dashboard'); 
    })->name('dashboard');
    
    Route::post('/logout', [AuthController::class , 'Logout'])->name('logout');
    Route::resource('customer-verification', CustomerController::class)->only(['index', 'show']);
    Route::post('/customer-verification/{id}/verify', [CustomerController::class, 'verify'])->name('customer-verification.verify');
});
