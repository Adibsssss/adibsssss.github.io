<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assign Teacher to Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::check() && Auth::user()->isAdmin())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('assign.teacher') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <!-- Select Course -->
                            <div>
                                <label for="course_id"
                                    class="block text-sm font-medium text-gray-700">{{ __('Course') }}</label>
                                <select name="course_id" id="course_id"
                                    class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="" disabled selected>Select a Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->subject_title }} ({{ $course->code }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Teacher -->
                            <div>
                                <label for="teacher_id"
                                    class="block text-sm font-medium text-gray-700">{{ __('Teacher') }}</label>
                                <select name="teacher_id" id="teacher_id"
                                    class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="" disabled selected>Select a Teacher</option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-full text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                {{ __('Assign Teacher') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="bg-white p-6 rounded shadow text-red-600 text-center">
                You do not have permission to view this page.
            </div>
            @endif
        </div>
    </div>
</x-app-layout>