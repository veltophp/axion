@extends('axion::layouts.app')

@section('axion::title')
    Settings | Axion Dashboard
@endsection

@section('axion::header')
    Settings
@endsection

@section('axion::content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
        <h1 class="text-2xl font-medium text-gray-800 dark:text-gray-100">Account Settings</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your account preferences and security</p>
    </div>

    <!-- Settings Form -->
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6 space-y-8">
        <form id="delete-picture-form" action="{{ route('delete.profile.picture') }}" method="POST" class="hidden">
            @csrf
        </form>

        <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            {!! csrf_field() !!}

            <!-- Name & Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ $profile->name }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-dark-600 bg-white dark:bg-dark-700 text-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Your full name">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ $profile->email }}"
                        disabled
                        class="w-full px-4 py-2.5 rounded-lg bg-gray-100 dark:bg-dark-700 text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-dark-600 cursor-not-allowed">
                </div>
            </div>

            <!-- Profile Picture -->
            <div class="">
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profile Picture</label>
                <div class="flex flex-col sm:flex-row items-center mt-4 gap-6">
                    <div class="text-center">
                        @if($profile->picture)
                            <img src="{{ $profile->picture }}" alt="Profile Picture"
                                 class="w-24 h-24 md:w-36 md:h-36 rounded-full border-2 border-white dark:border-dark-700 object-cover shadow-md mx-auto">
                            <button type="button" onclick="document.getElementById('delete-picture-form').submit();"
                                    class="mt-2 text-sm text-red-500 hover:underline">
                                Remove
                            </button>
                        @else
                            <img class="w-24 h-24 md:w-36 md:h-36 rounded-full border object-cover shadow-md mx-auto"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($profile->name) }}&background=f3f4f6&color=111827"
                                 alt="User avatar">
                        @endif
                    </div>
                    <div class="">
                        <input type="file" name="picture" id="image" class="block w-full text-sm text-gray-700 dark:text-gray-300">
                        @php echo fileInput('#image', 'picture') @endphp
                    </div>
                </div>
            </div>

            <!-- Bio -->
            <div>
                <label for="editor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bio</label>
                @php echo wysiwyg('#editor', 'bio', $profile->bio) @endphp
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-subtle p-6">
        <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4 flex items-center">
            <i class="fas fa-lock mr-2"></i> Change Password
        </h2>

        <div>@flash_errors</div>

        <form action="{{ route('update.password') }}" method="POST" class="space-y-6 mt-4">
            {!! csrf_field() !!}

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
                <div class="relative">
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-dark-600 bg-white dark:bg-dark-700 text-gray-800 dark:text-gray-100 pr-10 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="••••••••">
                    <i class="fas fa-eye-slash absolute right-3 top-3 text-gray-400 cursor-pointer toggle-password"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-dark-600 bg-white dark:bg-dark-700 text-gray-800 dark:text-gray-100 pr-10 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="••••••••">
                        <i class="fas fa-eye-slash absolute right-3 top-3 text-gray-400 cursor-pointer toggle-password"></i>
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-dark-600 bg-white dark:bg-dark-700 text-gray-800 dark:text-gray-100 pr-10 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="••••••••">
                        <i class="fas fa-eye-slash absolute right-3 top-3 text-gray-400 cursor-pointer toggle-password"></i>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <i class="fas fa-key mr-2"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', () => {
            const input = icon.previousElementSibling;
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('fa-eye', isHidden);
            icon.classList.toggle('fa-eye-slash', !isHidden);
        });
    });
</script>
@endsection
