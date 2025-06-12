@extends('axion::layouts.guest')

@section('axion::title')
    Register | Axion Dashboard
@endsection

@section('axion::content')

<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">

    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full">
        
        <div class="flex justify-center mb-6">
            <div class="flex items-center">
                <a href="{{route('home')}}">
                    <img src="https://res.cloudinary.com/drbowe2hn/image/upload/v1749617699/axion_jsr8c5.png" alt="Velto Logo"
                    class="w-24 h-12 object-contain"
                    loading="lazy"
                    width="96" height="48">
                </a>
            </div>
        </div>

        <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-gray-200 mb-6">Create an Account</h2>

        <div>@flash_errors</div>

        <form action="{{ route('process.register') }}" method="POST">
            
            {!! csrf_field() !!}
            
            <div class="mb-4">
                <label for="name" class="block text-gray-600 dark:text-gray-300 mb-2">Full Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required placeholder="Enter your full name">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-600 dark:text-gray-300 mb-2">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required placeholder="Enter your email">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-600 dark:text-gray-300 mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required placeholder="Enter your password">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-600 dark:text-gray-300 mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required placeholder="Confirm your password">
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg focus:outline-none mt-4">
                Register
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Already have an account? <a href="/login" class="text-blue-500 dark:text-blue-400 hover:underline">Login here</a>
            </p>
        </div>
    </div>
</div>
@endsection