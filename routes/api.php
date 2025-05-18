<?php 

use Illuminate\Support\Facades\Route;
use Sakshsky\SakshAuth\Http\Controllers\AuthController;

Route::prefix('otp-auth')->name('otp-auth.')->group(function () {
    Route::post('/request-otp', [AuthController::class, 'requestOtp'])->name('request');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify');
});