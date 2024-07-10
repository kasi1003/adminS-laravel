<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-gray-900 {{ session('dark_mode') ? 'dark' : '' }}">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="flex justify-between w-full sm:max-w-md px-6">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
            <div class="flex items-center">
                <label for="dark-mode-toggle" class="mr-2 text-gray-500 dark:text-gray-400">Dark Mode</label>
                <input type="checkbox" id="dark-mode-toggle" class="hidden" {{ session('dark_mode') ? 'checked' : '' }}>
                <label for="dark-mode-toggle" class="relative inline-flex items-center cursor-pointer">
                    <span class="sr-only">Dark Mode</span>
                    <span class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full border-2 border-transparent dark:border-gray-600 toggle-bg"></span>
                    <span class="absolute left-1 top-1 w-4 h-4 bg-white border-2 border-gray-300 rounded-full dark:border-gray-600 transform dark:translate-x-5 transition-transform duration-200"></span>
                </label>
            </div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('dark-mode-toggle');
            toggle.addEventListener('change', function () {
                fetch('/toggle-dark-mode', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ dark_mode: toggle.checked })
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>
