<?php

use Velto\Core\Route;
use Velto\Axion\Middleware\Guest;
use Velto\Axion\Middleware\Auth;

Route::group(['middleware' => [Guest::class]], function () {
    
    Route::get('/login', 'AuthController::login')->name('login');
    Route::post('/submit-login', 'AuthController::submitLogin')->name('submit.login');

    Route::get('/register', 'AuthController::register')->name('register');
    Route::post('/submit-register', 'AuthController::submitRegister')->name('process.register');

    Route::get('/verify-email', 'AuthController::verifyEmail')->name('verify.email');
    Route::post('/verify-email', 'AuthController::submitVerifyEmail')->name('submit.verify.email');
    Route::post('/resend-code', 'AuthController::resendCode')->name('resend.code');

    Route::get('/forgot-password', 'AuthController::forgotPasswordForm')->name('forgot.password');
    Route::post('/forgot-password', 'AuthController::submitForgotPassword')->name('submit.forgot.password');

    Route::get('/reset-password/{token}/{email}', 'AuthController::resetPasswordForm')->name('reset.password');
    Route::post('/reset-password', 'AuthController::resetPassword')->name('submit.reset.password');
    
});

Route::group(['middleware' => [Auth::class]], function () {

    Route::post('/logout', 'AuthController::logout')->name('logout');

});
