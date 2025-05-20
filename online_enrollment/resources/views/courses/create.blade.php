<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(auth()->user() && auth()->user()->isAdmin())
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('courses.store') }}">
                    @csrf

                    <!-- Code -->
                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-700">Course Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Title -->
                    <div class="mb-4">
                        <label for="subject_title" class="block text-sm font-medium text-gray-700">Subject Title</label>
                        <input type="text" name="subject_title" id="subject_title" value="{{ old('subject_title') }}"
                            required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('subject_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lecture Units -->
                    <div class="mb-4">
                        <label for="units_lec" class="block text-sm font-medium text-gray-700">Lecture Units</label>
                        <input type="number" name="units_lec" id="units_lec" value="{{ old('units_lec') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('units_lec')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lab Units -->
                    <div class="mb-4">
                        <label for="units_lab" class="block text-sm font-medium text-gray-700">Lab Units</label>
                        <input type="number" name="units_lab" id="units_lab" value="{{ old('units_lab') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('units_lab')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Credit -->
                    <div class="mb-4">
                        <label for="credit" class="block text-sm font-medium text-gray-700">Credit</label>
                        <input type="number" step="0.01" name="credit" id="credit" value="{{ old('credit') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('credit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('courses.index') }}"
                            class="px-4 py-2 rounded-full text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300">
                            Cancel
                        </a>

                        <x-primary-button
                            class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                            {{ __('Create Course') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            @else
            <p class="text-center text-red-500">You are not authorized to access this page.</p>
            @endif
        </div>
    </div>
</x-app-layout>