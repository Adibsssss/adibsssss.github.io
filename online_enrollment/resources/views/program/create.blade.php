<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">

                {{-- Display Errors --}}
                @if($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Form to Create Program --}}
                <form action="{{ route('program.store') }}" method="POST">
                    @csrf

                    {{-- Program Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Program Name</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    {{-- Program Code --}}
                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-700">Program Code</label>
                        <input type="text" name="code" id="code" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    {{-- Year Level --}}
                    <div class="mb-4">
                        <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                        <select name="year_level" id="year_level" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Year Level</option>
                            <option value="1" {{ old('year_level') == 1 ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ old('year_level') == 2 ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ old('year_level') == 3 ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ old('year_level') == 4 ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>

                    {{-- Semester --}}
                    <div class="mb-4">
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select name="semester" id="semester" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Semester</option>
                            <option value="1" {{ old('semester') == 1 ? 'selected' : '' }}>1st Semester</option>
                            <option value="2" {{ old('semester') == 2 ? 'selected' : '' }}>2nd Semester</option>
                        </select>
                    </div>

                    {{-- Courses (Subjects) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Courses (Subjects)</label>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($courses as $course)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                                        class="form-checkbox text-indigo-600">
                                    <span class="ml-2">{{ $course->name }} ({{ $course->code }})</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                            Create Program
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>