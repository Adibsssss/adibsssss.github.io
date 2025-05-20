<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6 px-8 py-10">
        @csrf

        <!-- Role Selection -->
        <div>
            <x-input-label for="role" :value="__('Register as')" class="text-gray-700 font-semibold" />
            <select id="role" name="role" required
                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition">
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                class="text-gray-700 font-semibold" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-300 transition" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-600 text-sm" />
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button
                class="py-3 px-8 rounded-full text-lg font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-indigo-400 transition">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>