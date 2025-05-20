<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6 px-8 py-10">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email"
                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password"
                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center space-x-2 text-gray-600">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="text-sm select-none">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                {{ __('Forgot your password?') }}
            </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button
                class="w-full py-3 rounded-full text-lg font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-indigo-400 transition">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>