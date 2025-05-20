<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Online Enrollment') }}</title>

    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/x-icon" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-800 min-h-screen flex">
    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-white shadow-lg border-r border-gray-200 min-h-screen sticky top-0">
        @include('layouts.navigation')
    </aside>

    <!-- Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto py-4 px-6">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6 max-w-7xl mx-auto w-full">
            <div class="relative isolate overflow-hidden mb-6">
                <div
                    class="absolute inset-0 -z-10 bg-[radial-gradient(45%_40%_at_50%_50%,rgba(79,70,229,0.05),rgba(255,255,255,0))]">
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer
            class="bg-white/80 backdrop-blur-sm border-t border-gray-200 py-4 px-6 text-center text-xs text-gray-500 select-none">
            &copy; {{ date('Y') }} {{ config('app.name', 'Online Enrollment') }}. All rights reserved.
        </footer>
    </div>

    @stack('scripts')
</body>

</html>