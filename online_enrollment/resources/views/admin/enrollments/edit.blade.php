<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Student Enrollment') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Student:</label>
                    <p>{{ optional($enrollment->user)->name }} ({{ optional($enrollment->user)->email }})</p>
                </div>

                <div class="mb-4">
                    <label for="section_id" class="block text-gray-700 font-bold mb-2">Select New Section:</label>
                    <select name="section_id" id="section_id"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($sections as $section)
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
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update
                        Section</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>