<?php

/**
 * Defines the routes for the Axion application. This file maps URLs to controller actions
 * and applies middleware for request processing and access control.
 */

use Velto\Core\Route;

use Velto\Axion\Middleware\Auth;

Route::group(['middleware' => [Auth::class]], function () {

    Route::get('/dashboard', 'DashboardController::index')->name('dashboard');
    Route::get('/profile', 'DashboardController::profile')->name('profile');
    Route::get('/settings', 'DashboardController::settings')->name('settings');
    Route::post('/settings/profile', 'DashboardController::updateProfile')->name('update.profile');
    Route::post('/settings/password', 'DashboardController::updatePassword')->name('update.password');
    Route::post('/settings/delete-profile-picture', 'DashboardController::deleteProfilePicture')->name('delete.profile.picture');

});