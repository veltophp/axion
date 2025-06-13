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

        <!-- Package Info -->
        <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Package Information</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3">
                    <span class="text-gray-500 dark:text-gray-400">Package</span>
                    <span class="font-medium text-gray-800 dark:text-gray-100">Axion | VeltoPHP</span>
                </div>
            </div>
        </div>
    </div>
@endsection