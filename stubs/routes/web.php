<?php

/**
 * Defines the routes for the Axion application. This file maps URLs to controller actions
 * and applies middleware for request processing and access control.
 */

use Velto\Core\Route;

use Velto\Axion\Middleware\Auth;
use Velto\Axion\Middleware\Admin;

Route::group(['middleware' => [Auth::class]], function () {

    Route::get('/dashboard', 'DashboardController::index')->name('dashboard');
    Route::get('/profile', 'DashboardController::profile')->name('profile');
    Route::get('/settings', 'DashboardController::settings')->name('settings');
    Route::post('/settings/profile', 'DashboardController::updateProfile')->name('update.profile');
    Route::post('/settings/password', 'DashboardController::updatePassword')->name('update.password');
    Route::post('/settings/delete-profile-picture', 'DashboardController::deleteProfilePicture')->name('delete.profile.picture');

});

Route::group(['middleware' => [Auth::class, Admin::class]], function () {


    Route::get('/blog/post/create', 'BlogDashboardController::createPost')->name('create.post');
    Route::get('/blog/post/all-post', 'BlogDashboardController::allPost')->name('all.post');
    Route::post('/blog/post/submit', 'BlogDashboardController::submitPost')->name('submit.post');
    Route::post('/blog/post/update/{post_id}', 'BlogDashboardController::updatePost')->name('update.post');
    Route::get('/blog/post-edit/{post_id}', 'BlogDashboardController::editPost')->name('edit.post');
    Route::get('/blog/post-delete/{post_id}', 'BlogDashboardController::deletePost')->name('delete.post');


    // Blog Topics Routes
    Route::get('/blog/topics', 'BlogTopicController::index')->name('topics');
    Route::post('/blog/topics/submit', 'BlogTopicController::store')->name('submit.topics');
    Route::get('/blog/topics/edit/{topic_id}', 'BlogTopicController::edit')->name('edit.topics');
    Route::post('/blog/topics/update/{topic_id}', 'BlogTopicController::update')->name('update.topics');
    Route::get('/blog/topics/delete/{topic_id}', 'BlogTopicController::destroy')->name('delete.topics');



    //Blog Category Routes
    Route::get('/blog/categories', 'BlogCategoryController::index')->name('categories');
    Route::post('/blog/categories/submit', 'BlogCategoryController::store')->name('submit.categories');
    Route::get('/blog/categories/edit/{category_id}', 'BlogCategoryController::edit')->name('edit.categories');
    Route::post('/blog/categories/update/{category_id}', 'BlogCategoryController::update')->name('update.categories');
    Route::get('/blog/categories/delete/{category_id}', 'BlogCategoryController::destroy')->name('delete.categories');



});


Route::get('/blog/post-view/{slug}', 'BlogDashboardController::viewPost')->name('view.post');

Route::get('/blog/categories/{category}/{category_id}', 'BlogCategoryController::indexCategory')->name('post.category');
Route::get('/blog/topics/{topic}/{topic_id}', 'BlogTopicController::indexTopic')->name('post.topic');

Route::get('/blog', 'BlogDashboardController::blogIndex')->name('blog');
