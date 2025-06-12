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

<body class="bg-white text-gray-800 font-sans antialiased dark:bg-dark-800 dark:text-gray-200">

    @yield('axion::content')

    <button id="theme-toggle" type="button" class="fixed right-6 bottom-5 z-50 p-2 rounded-full bg-white/80 dark:bg-dark-700/80 backdrop-blur shadow-md hover:bg-gray-100 dark:hover:bg-dark-600 transition-all">
        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
        </svg>
    </button>
</body>

</html>
