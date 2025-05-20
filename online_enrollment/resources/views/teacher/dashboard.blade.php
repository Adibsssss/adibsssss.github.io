<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
            {{ __('My Class Assignments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-6 border-b border-gray-200">
                    {{-- Success & Error Messages --}}
                    @if(session('success'))
                    <div
                        class="mb-6 rounded-md bg-green-50 border border-green-400 text-green-700 px-5 py-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div
                        class="mb-6 rounded-md bg-red-50 border border-red-400 text-red-700 px-5 py-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Header --}}
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Assigned Courses & Sections') }}</h3>

                    {{-- Courses Table --}}
                    <div class="overflow-x-auto">
                        @if($courses->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @php
                                    $headers = ['Course Code', 'Subject Title', 'Section', 'Program', 'Schedule'];
                                    @endphp
                                    @foreach ($headers as $header)
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        {{ $header }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($courses as $course)
                                @foreach($course->programs as $program)
                                @foreach($program->sections as $section)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->code }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $course->subject_title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $section->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $program->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @foreach($course->schedules as $schedule)
                                        <div>{{ $schedule->day_of_week }}:
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div
                            class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded text-yellow-700 text-sm font-medium">
                            You have no assigned courses yet.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>