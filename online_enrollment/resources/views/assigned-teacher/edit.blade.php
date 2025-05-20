<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Assigned Teachers - {{ $course->subject_title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                {{-- Flash messages --}}
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Assigned Teachers List --}}
                @if($course->teachers->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Currently Assigned Teachers</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach($course->teachers as $teacher)
                        <li class="py-2 flex justify-between items-center">
                            <span>{{ $teacher->name }}</span>
                            <form action="{{ route('remove.single.teacher', [$course->id, $teacher->id]) }}"
                                method="POST" onsubmit="return confirm('Remove this teacher from the course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Remove
                                </button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Replace a Teacher --}}
                <div class="mt-10 pt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Replace a Teacher</h3>
                    <form method="POST" action="{{ route('assign.teacher.replace', $course->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Old Teacher</label>
                            <select name="old_teacher_id"
                                class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($course->teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">New Teacher</label>
                            <select name="new_teacher_id"
                                class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($teachers as $teacher)
                                @unless($course->teachers->contains($teacher->id))
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endunless
                                @endforeach
                            </select>
                        </div>
                        <x-primary-button
                            class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                            {{ __('Replace Teacher') }}
                        </x-primary-button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>