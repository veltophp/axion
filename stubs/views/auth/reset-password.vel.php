@extends('axion::layouts.guest')

@section('axion::title')
    Reset Password | Axion Dashboard
@endsection

@section('axion::content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">

        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-sm w-full">

            <div class="flex justify-center mb-6">
                <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">Axion</span>
            </div>

            <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-gray-200 mb-6">Reset Your Password</h2>

            <div class="text-center text-gray-600 dark:text-gray-300 mb-4">
                Please enter your new password below.
            </div>

            <div>@flash_errors</div>

            <form action="{{ route('submit.reset.password') }}" method="POST">
                {!! csrf_field() !!}

                <input type="hidden" name="email" value="{{ $email ?? '' }}">
                <input type="hidden" name="token" value="{{ $token ?? '' }}">

                <div class="mb-4">
                    <label for="password" class="block text-gray-600 dark:text-gray-300 mb-2">New Password</label>
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required placeholder="Enter new password">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-600 dark:text-gray-300 mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required placeholder="Confirm new password">
                </div>

                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg focus:outline-none">
                    Reset Password
                </button>
            </form>

        </div>

    </div>

@endsection
