<!DOCTYPE <html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Enrollment System') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col justify-between">
        <!-- Navigation -->
        <nav class="border-b border-gray-200 backdrop-blur-lg bg-white/90 fixed w-full z-10 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <!-- Logo or icon image -->
                            <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-8 w-auto">
                            <span
                                class="ml-2 text-xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-700 bg-clip-text text-transparent">ENROLL</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-sm font-medium text-gray-600 hover:text-indigo-700 transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm font-medium text-gray-600 hover:text-indigo-700 transition">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-indigo-700 transition">Log in</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="ml-4 px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">Register</a>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>


        <!-- Main Content -->
        <main class="flex-grow">
            <div class="relative isolate overflow-hidden">
                <div
                    class="absolute inset-0 -z-10 bg-[radial-gradient(45%_40%_at_50%_50%,rgba(79,70,229,0.1),rgba(255,255,255,0))]">
                </div>
                <div
                    class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white/40 shadow-xl shadow-indigo-500/10 ring-1 ring-indigo-500/10 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center">
                </div>

                <div class="mx-auto max-w-7xl px-6 py-32 sm:py-40 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                            Future of Education
                            <span class="block text-indigo-600">Online Enrollment</span>
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            Streamline your academic journey with our cutting-edge enrollment system.
                            Quick registration, real-time updates, and seamless course management.
                        </p>
                        <div class="mt-10 flex items-center gap-x-6">
                            <a href="{{ route('register') }}"
                                class="rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-300 ease-in-out">
                                Get started
                            </a>
                            <a href="#features" class="text-sm font-semibold leading-6 text-gray-900">
                                Learn more <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div id="features" class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-indigo-600">Enrollment Made Simple</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Everything you need for
                        a seamless enrollment experience</p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                        <div
                            class="backdrop-blur-sm bg-white/80 rounded-2xl p-6 border border-gray-200 shadow-sm hover:border-indigo-300 transition-all duration-300">
                            <dt class="flex items-center gap-x-3 text-lg font-semibold leading-7 text-gray-900">
                                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Instant Registration
                            </dt>
                            <dd class="mt-4 text-base leading-7 text-gray-600">
                                Sign up and complete your enrollment in minutes. No paperwork, no waiting.
                            </dd>
                        </div>
                        <div
                            class="backdrop-blur-sm bg-white/80 rounded-2xl p-6 border border-gray-200 shadow-sm hover:border-indigo-300 transition-all duration-300">
                            <dt class="flex items-center gap-x-3 text-lg font-semibold leading-7 text-gray-900">
                                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Smart Course Selection
                            </dt>
                            <dd class="mt-4 text-base leading-7 text-gray-600">
                                AI-powered recommendations for courses based on your academic goals and past
                                performance.
                            </dd>
                        </div>
                        <div
                            class="backdrop-blur-sm bg-white/80 rounded-2xl p-6 border border-gray-200 shadow-sm hover:border-indigo-300 transition-all duration-300">
                            <dt class="flex items-center gap-x-3 text-lg font-semibold leading-7 text-gray-900">
                                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Secure & Private
                            </dt>
                            <dd class="mt-4 text-base leading-7 text-gray-600">
                                Your academic data is protected with industry-leading security standards.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white/80 backdrop-blur-md border-t border-gray-200">
            <div class="mx-auto max-w-7xl px-6 py-8 md:flex md:items-center md:justify-between lg:px-8">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="#" class="text-gray-500 hover:text-indigo-600">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </div>
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center text-xs leading-5 text-gray-500">
                        &copy; {{ date('Y') }} Enrollment System. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>