@extends('axion::layouts.guest')

@section('axion::title')
    Email Verification | Axion Dashboard
@endsection

@section('axion::content')

    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">

        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-sm w-full">

            <div class="flex justify-center mb-6">

                <span class="text-3xl font-bold text-blue-600 dark:text-blue-400">Axion</span>

            </div>

            <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-gray-200 mb-6">Verify Your Email</h2>
            
            <div class="text-center text-gray-600 dark:text-gray-300 mb-4">We have sent a verification email to: {{$email = session()->email}}. Please check your inbox.</div>


            <div>@flash_errors</div>

            <form action="{{route('submit.verify.email')}}" method="POST">
                
                {!! csrf_field() !!}

                <div class="mb-4">
                    <label for="code" class="block text-gray-600 dark:text-gray-300 mb-2">Verification Code </label>
                    <input type="text" id="code" name="code"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required maxlength="5" pattern="\d{5}" placeholder="Enter 5-digit code">
                </div>

                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg focus:outline-none">
                    Verify Email
                </button>
            </form>

            <div class="text-center mt-4">

                <form action="{{route('resend.code')}}" method="POST">

                    {!! csrf_field() !!}
                    <button type="submit" class="text-sm text-blue-500 hover:underline dark:text-blue-400">
                        Resend Code
                    </button>

                </form>

            </div>

        </div>

    </div>

@endsection
