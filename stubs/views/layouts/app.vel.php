<!DOCTYPE html>
<html lang="en">

    {{-- VeltoPHP Framework
    -----------------
    VeltoPHP is a lightweight, fast, and minimalist PHP framework designed
    for building modern static and dynamic web projects with simplicity
    and efficiency in mind.

    Official Website: https://veltophp.com
    License: MIT License - You are free to use, modify, and distribute
    the software under the terms of the MIT license.

    Maintained by: veltophp Team
    Contact Email: dev@veltophp.com
    Instagram: https://instagram.com/veltophp

    Thank you for using VeltoPHP! For documentation, tutorials, and
    community support, please visit our website. --}}
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('axion::title', 'Axion | A Simple Admin Dashboard for VeltoPHP')</title>
    <link rel="icon" href="https://res.cloudinary.com/drbowe2hn/image/upload/v1749287950/FAVICON_cfszfv.png" type="image/png">
    <meta name="description" content="Create a simple Admin Dashboard for your Velto Projects">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="/assets/js/dark-thema.js" defer></script>
    <!-- watch auto reload -->
    <script src="/assets/js/watch.js"></script>
    <!-- aditional script   -->
    <script src="/assets/js/script.js" defer></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        }
                    }
                }
            }
        }
    </script>
</head>
<style>
    .sidebar-hidden {
        transform: translateX(-100%);
    }

    @media (min-width: 1024px) {
        .sidebar-hidden {
            transform: none !important;
        }
    }

    /* Smooth transitions */
    .transition-slow {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Subtle shadow for depth */
    .shadow-subtle {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    /* Modern scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 3px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.7);
    }
</style>
<body class="bg-gray-50 text-gray-800 font-sans antialiased dark:bg-dark-900 dark:text-gray-200 transition-slow">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Backdrop -->
        <div id="sidebar-backdrop" class="fixed inset-0 z-20 bg-black/30 lg:hidden hidden transition-opacity"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-hidden fixed lg:relative w-64 h-full bg-white dark:bg-dark-800 border-r border-gray-200 dark:border-gray-800 z-30 transition-transform duration-300 ease-in-out overflow-hidden flex flex-col">

            <!-- Logo -->
            <div class="flex items-center h-16 px-6 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center">
                    <a href="{{route('home')}}">
                        <img src="https://res.cloudinary.com/drbowe2hn/image/upload/v1749617699/axion_jsr8c5.png" alt="Velto Logo"
                        class="w-24 h-12 object-contain"
                        loading="lazy"
                        width="96" height="48">
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-3 overflow-y-auto" id="sidebar-nav">
                <div class="space-y-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700/50 group @active('/dashboard', 'font-medium bg-primary-50 dark:bg-gray-700/50 text-primary-600 dark:text-primary-400') transition-slow">
                        <i class="fas fa-tachometer-alt w-5 text-center text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"></i>
                        <span class="ml-3 whitespace-nowrap">Dashboard</span>
                    </a>
                
                    <a href="{{ route('profile') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700/50 group @active('/profile', 'font-medium bg-primary-50 dark:bg-gray-700/50 text-primary-600 dark:text-primary-400') transition-slow">
                        <i class="fas fa-user w-5 text-center text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"></i>
                        <span class="ml-3 whitespace-nowrap">Profile</span>
                    </a>
                
                    <a href="{{ route('settings') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700/50 group @active('/settings', 'font-medium bg-primary-50 dark:bg-gray-700/50 text-primary-600 dark:text-primary-400') transition-slow">
                        <i class="fas fa-cog w-5 text-center text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"></i>
                        <span class="ml-3 whitespace-nowrap">Settings</span>
                    </a>
                </div>
                
                <div class="py-8 border-t border-gray-200 dark:border-gray-800">
                    <form action="{{route('logout')}}" method="POST" class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700/50 group transition-slow">
                        {!! csrf_field() !!}
                        <button type="submit" class="flex items-center space-x-3 w-full">
                            <i class="fas fa-sign-out-alt w-5 text-center text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400"></i>
                            <span class="whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Footer -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-800 text-center text-xs text-gray-500 dark:text-gray-400">
                Axion | VeltoPHP
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 dark:bg-dark-900 transition-slow">

            <!-- Header -->
            <header class="flex items-center justify-between h-16 px-6 bg-white dark:bg-dark-800 border-b border-gray-200 dark:border-gray-800 shadow-subtle">
                <div class="flex items-center">
                    <button id="toggleSidebar" class="mr-4 text-gray-500 dark:text-gray-400 lg:hidden hover:text-primary-600 dark:hover:text-primary-400 transition-slow">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-medium text-gray-800 dark:text-gray-200">@yield('axion::header', '')</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-700 dark:text-gray-300 mr-3 hidden md:inline">{{ Auth::user()->name }}</span>
                        <div class="flex items-center justify-center text-primary-600 dark:text-primary-300 font-medium text-sm">
                            <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=f3f4f6&color=111827' }}" class="w-8 h-8 border rounded-full" alt="">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('axion::content')
            </main>
        </div>
    </div>

    <!-- Theme Toggle -->
    <button id="theme-toggle" type="button" class="fixed right-6 bottom-5 z-50 p-3 rounded-full bg-white/80 dark:bg-dark-700/80 backdrop-blur shadow-md hover:bg-gray-100 dark:hover:bg-dark-600 transition-all border border-gray-200 dark:border-gray-700">
        <svg id="theme-toggle-dark-icon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
        <svg id="theme-toggle-light-icon" class="w-4 h-4 hidden" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
    </button>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const backdrop = document.getElementById('sidebar-backdrop');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-hidden');
            backdrop.classList.toggle('hidden');
        });

        backdrop.addEventListener('click', () => {
            sidebar.classList.add('sidebar-hidden');
            backdrop.classList.add('hidden');
        });
    </script>
</body>
</html>