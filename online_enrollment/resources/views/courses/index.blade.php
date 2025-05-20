<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::check() && Auth::user()->isAdmin())
            <div class="flex justify-end mb-6">
                <a href="{{ route('courses.create') }}"
                    class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    {{ __('Create new course') }}
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($courses->isEmpty())
                    <p class="text-gray-500">No courses available.</p>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        Course Title
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        Code
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        Lecture Units
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        Lab Units
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        Credit
                                    </th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($courses as $course)
                                <tr>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">{{ $course->subject_title }}</td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">{{ $course->code }}</td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">{{ $course->units_lecture }}</td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">{{ $course->units_lab }}</td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">{{ $course->credit }}</td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('courses.edit', $course->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-sm font-medium rounded-md hover:bg-blue-200 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this course?');">
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
                        <div class="mt-6">
                            {{ $courses->links() }}
                        </div>
                    </div>
                    @endif
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