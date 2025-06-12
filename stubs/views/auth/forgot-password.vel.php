@extends('axion::layouts.guest')

@section('axion::title')
    Forgot Password | Axion
@endsection

@section('axion::content')
<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-sm w-full">

        <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-gray-200 mb-6">
            Forgot Password
        </h2>

        <div>@flash_errors</div>

        <form action="{{ route('submit.forgot.password') }}" method="POST">
            {!! csrf_field() !!}

            <div class="mb-4">
                <label for="email" class="block text-gray-600 dark:text-gray-300 mb-2">Your Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your email address">
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg focus:outline-none">
                Send Reset Code
            </button>
        </form>
    </div>
</div>
@endsection
