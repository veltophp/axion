@extends('axion::layouts.app')

@section('axion::title')
    Dashboard | Axion Dashboard
@endsection

@section('axion::header')
    Dashboard
@endsection

@section('axion::content')
    <div class="space-y-6 max-w-4xl mx-auto">
        <!-- Welcome Header -->
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
            <h2 class="text-2xl font-medium text-gray-800 dark:text-gray-100">Welcome back, {{ Auth::user()->name }}</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Here's what's happening with your dashboard today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Posts</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">0</p>
                    </div>
                    <div class="p-3 rounded-lg bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Categories</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">0</p>
                    </div>
                    <div class="p-3 rounded-lg bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                        <i class="fas fa-folder"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Topics</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">0</p>
                    </div>
                    <div class="p-3 rounded-lg bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Users</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mt-1">0</p>
                    </div>
                    <div class="p-3 rounded-lg bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Package Info -->
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Package Information</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Package</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Axion | VeltoPHP</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400">Version</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">1.2.0</span>
                </div>
            </div>
        </div>
    </div>
@endsection