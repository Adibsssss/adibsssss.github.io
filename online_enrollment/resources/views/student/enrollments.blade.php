<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Enrollments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                <div class="mb-4 text-red-600">{{ session('error') }}</div>
                @endif

                @if ($enrollments->isEmpty())
                <p>You are not enrolled in any sections.</p>

                @if ($availableSections->isEmpty())
                <p>No available sections for enrollment.</p>
                @else
                <h3 class="text-lg font-semibold mt-6 mb-2">Available Sections:</h3>
                <table class="w-full table-auto border-collapse mb-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Program Code</th>
                            <th class="border px-4 py-2 text-left">Section Name</th>
                            <th class="border px-4 py-2 text-left">Enrolled</th>
                            <th class="border px-4 py-2 text-left">Max Students</th>
                            <th class="border px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($availableSections as $section)
                        <tr>
                            <td class="border px-4 py-2">
                                {{ $section->program->code ?? 'N/A' }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $section->name }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $section->enrollments_count ?? '0' }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $section->max_students }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('student.enroll', $section->id) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                    Enroll
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @else
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th
                                class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Course code </th>
                            <th
                                class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Program</th>
                            <th
                                class="py-3 px-4 border-b bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Section</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrollments as $enrollment)
                        @php
                        $courseProgram = $enrollment->section->coursePrograms->first();
                        @endphp
                        <tr>
                            <td class="py-4 px-4 border-b text-sm text-gray-700">
                                {{ $courseProgram->course->code ?? 'N/A' }}</td>
                            <td class="py-4 px-4 border-b text-sm text-gray-700">
                                {{ $courseProgram->program->name ?? 'N/A' }}</td>
                            <td class="py-4 px-4 border-b text-sm text-gray-700">{{ $enrollment->section->name }}</td>
                        </tr>
                        @endforeach


                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>