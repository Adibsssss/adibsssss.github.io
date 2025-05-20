<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('course_schedules.create') }}"
                    class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    {{ __('Create new schedule') }}
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($schedules->isEmpty())
                    <p class="text-gray-500">No schedules available.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Course
                                    </th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Day
                                    </th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start Time
                                    </th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        End Time
                                    </th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                <tr>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">{{ $schedule->course->code }}
                                        - {{ $schedule->course->subject_title }}</td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">{{ $schedule->day_of_week }}
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">{{ $schedule->start_time }}
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">{{ $schedule->end_time }}
                                    </td>
                                    <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('course_schedules.edit', $schedule) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-sm font-medium rounded-md hover:bg-blue-200 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('course_schedules.destroy', $schedule) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-sm font-medium rounded-md hover:bg-red-200 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $schedules->links('pagination::tailwind', ['class' => 'px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700']) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>