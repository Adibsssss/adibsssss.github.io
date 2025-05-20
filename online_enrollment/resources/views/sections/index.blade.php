<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Success & Error Messages --}}
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

                    {{-- Header and New Section Button --}}
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-700">{{ __('Section List') }}</h3>
                        <a href="{{ route('sections.create') }}"
                            class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                            {{ __('+ Add Section') }}
                        </a>
                    </div>

                    {{-- Table Content --}}
                    <div class="overflow-x-auto">
                        @if($sections->count() > 0)
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Max Students
                                    </th>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Load Type
                                    </th>
                                    <th
                                        class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $section)
                                <tr>
                                    <td class="py-4 px-4 border-b text-sm text-gray-700">{{ $section->name }}</td>
                                    <td class="py-4 px-4 border-b text-sm text-gray-700">{{ $section->max_students }}
                                    </td>
                                    <td class="py-4 px-4 border-b text-sm text-gray-700">{{ $section->load_type }}</td>
                                    <td class="py-4 px-4 border-b text-sm">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('sections.edit', $section) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 text-sm font-medium rounded-md hover:bg-green-200 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('sections.destroy', $section) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this section?');">
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

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $sections->links() }}
                        </div>
                        @else
                        <div class="bg-yellow-50 p-4 rounded text-yellow-600">
                            No sections available. Click the "Add Section" button to create one.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>