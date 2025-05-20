<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(Auth::check() && Auth::user()->isAdmin())
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('courses.update', $course->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Code -->
                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code', $course->code) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Title -->
                    <div class="mb-4">
                        <label for="subject_title" class="block text-sm font-medium text-gray-700">Subject Title</label>
                        <input type="text" name="subject_title" id="subject_title"
                            value="{{ old('subject_title', $course->subject_title) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('subject_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Units Lecture -->
                    <div class="mb-4">
                        <label for="units_lecture" class="block text-sm font-medium text-gray-700">Units
                            (Lecture)</label>
                        <input type="number" name="units_lecture" id="units_lecture"
                            value="{{ old('units_lecture', $course->units_lecture) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('units_lecture')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Units Lab -->
                    <div class="mb-4">
                        <label for="units_lab" class="block text-sm font-medium text-gray-700">Units (Lab)</label>
                        <input type="number" name="units_lab" id="units_lab"
                            value="{{ old('units_lab', $course->units_lab) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('units_lab')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Credit -->
                    <div class="mb-4">
                        <label for="credit" class="block text-sm font-medium text-gray-700">Credit</label>
                        <input type="number" step="0.01" name="credit" id="credit"
                            value="{{ old('credit', $course->credit) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('credit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('courses.index') }}"
                            class="px-4 py-2 rounded-full text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition">
                            Cancel
                        </a>

                        <x-primary-button
                            class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                            {{ __('Update Course') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            @else
            <div class="bg-white shadow sm:rounded-lg p-6 text-center text-gray-600">
                You are not authorized to edit this course.
            </div>
            @endif
        </div>
    </div>
</x-app-layout>