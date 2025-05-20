<x-app-layout>
    <style>
    @media print {
        body {
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .print\:hidden {
            display: none !important;
        }

        .cor-content {
            font-size: 10px;
        }

        header,
        footer,
        aside,
        nav,
        form,
        iframe,
        .menu,
        .hero,
        .adslot {
            display: none !important;
        }

        .p-6,
        .py-4,
        .shadow-sm {
            padding: 0 !important;
            box-shadow: none !important;
        }

        .border,
        .border-black {
            border-color: black !important;
            border-width: 1px !important;
        }

        .text-gray-500 {
            color: black !important;
        }
    }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Certificate of Registration') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex justify-end">
                    <button onclick="window.print()"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded print:hidden">
                        Print COR
                    </button>
                </div>

                <div class="cor-content">
                    <div class="border border-black p-4 rounded-md">
                        <div class="text-center font-bold text-xl mb-4">STUDENT GENERAL INFORMATION</div>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <div class="flex">
                                <div class="w-1/3 font-semibold">Name:</div>
                                <div>{{ $student->name }}</div>
                            </div>
                        </div>

                        <div class="mt-2 flex justify-end gap-6 text-sm">
                            <div><strong>Total Lecture Units:</strong> {{ $totalLecUnits }}</div>
                            <div><strong>Total Lab Units:</strong> {{ $totalLabUnits }}</div>
                            <div><strong>Total Credits:</strong> {{ $totalCredits }}</div>
                        </div>

                        <div class="border border-black mt-4 rounded-md overflow-x-auto">
                            <table class="w-full border-collapse text-xs table-fixed">
                                <thead>
                                    <tr class="bg-gray-100 text-center">
                                        <th class="border border-black p-1 w-1/12">CODE</th>
                                        <th class="border border-black p-1 w-3/12">SUBJECT TITLE</th>
                                        <th class="border border-black p-1 w-1/12">LEC</th>
                                        <th class="border border-black p-1 w-1/12">LAB</th>
                                        <th class="border border-black p-1 w-1/12">CREDIT</th>
                                        <th class="border border-black p-1 w-1/12">SECTION</th>
                                        <th class="border border-black p-1 w-2/12">SCHEDULE/ROOM</th>
                                        <th class="border border-black p-1 w-2/12">FACULTY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($enrollmentData as $data)
                                    <tr>
                                        <td class="border border-black p-1 text-center">
                                            {{ $data['course']->code ?? 'N/A' }}</td>
                                        <td class="border border-black p-1">
                                            {{ $data['course']->subject_title ?? 'N/A' }}</td>
                                        <td class="border border-black p-1 text-center">
                                            {{ $data['course']->units_lecture ?? '0' }}</td>
                                        <td class="border border-black p-1 text-center">
                                            {{ $data['course']->units_lab ?? '0' }}</td>
                                        <td class="border border-black p-1 text-center">
                                            {{ $data['course']->credit ?? '0' }}</td>
                                        <td class="border border-black p-1 text-center">
                                            {{ $data['enrollment']->section->name ?? 'N/A' }}</td>
                                        <td class="border border-black p-1 text-center">
                                            @if(isset($data['course']->schedules) &&
                                            $data['course']->schedules->count())
                                            @foreach($data['course']->schedules as $schedule)
                                            {{ $schedule->day_of_week }}
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:ia') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:ia') }}
                                            @if(!$loop->last), @endif
                                            @endforeach
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td class="border border-black p-1">
                                            @if(isset($data['course']->teachers) && $data['course']->teachers->count())
                                            @foreach($data['course']->teachers as $teacher)
                                            {{ $teacher->name ?? 'N/A' }}@if(!$loop->last), @endif
                                            @endforeach
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8"
                                            class="border border-black p-1 text-center text-sm text-gray-500">No courses
                                            found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-10 grid grid-cols-3 gap-4 text-center text-sm">
                            <div>
                                <div class="border-b border-black pb-1 h-8">____________________________</div>
                                <div class="pt-1">Student's Signature</div>
                            </div>
                            <div></div>
                            <div>
                                <div class="border-b border-black pb-1 h-8">____________________________</div>
                                <div class="pt-1">Registrar</div>
                            </div>
                        </div>

                        <div class="mt-6 text-sm text-gray-500 print:text-xs">
                            <p>Printed on: {{ date('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>