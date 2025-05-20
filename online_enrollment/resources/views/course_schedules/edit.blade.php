<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('course_schedules.update', $courseSchedule) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Course</label>
                        <select name="course_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ $courseSchedule->course_id == $course->id ? 'selected' : '' }}>
                                {{ $course->code }} - {{ $course->subject_title }}
                            </option>
                            @endforeach
                        </select>
                        @error('course_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Day</label>
                        <select name="day_of_week" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                            <option value="{{ $day }}" {{ $courseSchedule->day_of_week == $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                            @endforeach
                        </select>
                        @error('day_of_week')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Start Time</label>
                        <input type="text" name="start_time"
                            value="{{ old('start_time', $courseSchedule->start_time) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. 08:00 AM">
                        @error('start_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">End Time</label>
                        <input type="text" name="end_time" value="{{ old('end_time', $courseSchedule->end_time) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. 10:00 AM">
                        @error('end_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>