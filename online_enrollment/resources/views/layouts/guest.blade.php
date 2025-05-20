<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Online Enrollment') }}</title>

    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-12">
        <div class="relative isolate overflow-hidden">
            <div
                class="absolute inset-0 -z-10 bg-[radial-gradient(45%_40%_at_50%_50%,rgba(79,70,229,0.1),rgba(255,255,255,0))]">
            </div>
        </div>

        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-12 w-auto">
                        <span
                            class="ml-2 text-3xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 bg-clip-text text-transparent">ENROLL</span>
                    </div>
                </a>
            </div>

            <div class="bg-white/90 backdrop-blur-lg shadow-lg rounded-xl overflow-hidden border border-gray-200">
                {{ $slot }}
            </div>

            <div class="text-center mt-6 text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Online Enrollment') }}. All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>