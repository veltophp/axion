@extends('axion::layouts.app')

@section('axion::title')
    Profile | Axion Dashboard
@endsection

@section('axion::header')
    Profile
@endsection

@section('axion::content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
        <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100">Profile Settings</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your personal information and account preferences</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Personal Information</h3>
        </div>
        
        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Avatar Section -->
                <div class="flex-shrink-0 flex flex-col items-center">
                    <div class="relative">
                        <img class="w-24 h-24 rounded-full border-2 border-white dark:border-dark-700 shadow-md object-cover"
                             src="{{ $profile->picture ?: 'https://ui-avatars.com/api/?name=' . urlencode($profile->name) . '&background=f3f4f6&color=111827' }}"
                             alt="{{ $profile->name }}'s profile picture">
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="flex-1 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                            <div class="bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 rounded-lg">
                                {{ $profile->name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                            <div class="bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 rounded-lg">
                                {{ $profile->email }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Member Since</label>
                        <div class="bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-100 px-4 py-2.5 rounded-lg">
                            {{ format($profile->created_at) }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">About</label>
                        @if($profile->bio)
                        <div class="bg-gray-50 dark:bg-dark-700 text-gray-800 dark:text-gray-100 px-4 py-3 rounded-lg prose dark:prose-invert max-w-none">
                            {!! $profile->bio !!}
                        </div>
                        @else
                        <div class="bg-gray-50 dark:bg-dark-700 text-gray-500 dark:text-gray-400 px-4 py-3 rounded-lg italic">
                            No bio added yet
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection