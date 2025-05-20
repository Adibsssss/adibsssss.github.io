<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Enrollments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-700">{{ __('All Student Enrollments') }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.enrollments.download') }}"
                                class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700">
                                {{ __('Download PDF') }}
                            </a>
                            <a href="{{ route('admin.enrollments.create') }}"
                                class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                                {{ __('+ Enroll Student') }}
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        @if($enrollments->count() > 0)
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                        Student</th>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                        Email</th>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                        Section</th>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                        Enrolled On</th>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollments as $enrollment)
                                <tr>
                                    <td class="py-4 px-4 border-b text-sm text-gray-700">{{ $enrollment->user->name }}
                                    </td>
                                    <td class="py-4 px-4 border-b text-sm text-gray-700">{{ $enrollment->user->email }}
                                    </td>
                                    <td class="py-4 px-4 border-b text-sm text-gray-700">
                                        {{ $enrollment->section->name ?? 'N/A' }}</td>
                                    <td class="py-4 px-4 border-b text-sm text-gray-700">
                                        {{ $enrollment->created_at->format('M d, Y') }}</td>
                                    <td class="py-4 px-4 border-b text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.enrollments.edit', $enrollment) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 text-sm font-medium rounded-md hover:bg-blue-200 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                                                method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 text-sm font-medium rounded-md hover:bg-red-200 transition">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $enrollments->links() }}
                        </div>
                        @else
                        <div class="bg-yellow-50 p-4 rounded text-yellow-600">
                            No enrollments found.
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>