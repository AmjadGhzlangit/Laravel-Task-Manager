<?php

use App\Http\API\V1\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('request-email-otp', [AuthController::class, 'requestEmailOTP']);
    Route::post('verify-otp/email', [AuthController::class, 'verifyEmailOTP']);
    Route::put('update/{user}', [AuthController::class, 'update']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout'])->name('token.logout');
});
