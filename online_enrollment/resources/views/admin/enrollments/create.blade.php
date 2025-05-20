<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enroll Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Error Message --}}
                    @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.enrollments.store') }}">
                        @csrf

                        {{-- Select Student --}}
                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Select Student</label>
                            <select id="user_id" name="user_id" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('user_id') border-red-500 @enderror">
                                <option value="">-- Select Student --</option>
                                @foreach ($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} ({{ $student->email }})
                                </option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Select Section --}}
                        <div class="mb-4">
                            <label for="section_id" class="block text-sm font-medium text-gray-700">Select
                                Section</label>
                            <select id="section_id" name="section_id" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('section_id') border-red-500 @enderror">
                                <option value="">-- Select Section --</option>
                                @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ $section->enrollments_count >= $section->max_students ? 'disabled' : '' }}>
                                    {{ $section->program?->name }} - {{ $section->course?->name }} -
                                    {{ $section->name }}
                                    ({{ $section->enrollments_count }}/{{ $section->max_students }} students)
                                    {{ $section->enrollments_count >= $section->max_students ? '(FULL)' : '' }}
                                </option>
                                @endforeach
                            </select>
                            @error('section_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.enrollments.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-gray-800 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                + Enroll Student
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>