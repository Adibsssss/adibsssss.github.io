<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Section') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('sections.update', $section) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="program_id" class="block text-sm font-medium text-gray-700">Program</label>
                        <select name="program_id" id="program_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select a program</option>
                            @foreach($programs as $program)
                            <option value="{{ $program->id }}"
                                {{ (old('program_id', $section->program_id) == $program->id) ? 'selected' : '' }}>
                                {{ $program->code }} - {{ $program->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Courses</label>
                        <div id="course-options" class="mt-2 space-y-2">
                            @if($coursePrograms->count() > 0)
                            @foreach($coursePrograms as $cp)
                            @if($cp->program_id == $section->program_id)
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="course_program_ids[]" value="{{ $cp->id }}"
                                    id="course_{{ $cp->id }}"
                                    {{ $section->coursePrograms->contains($cp->id) ? 'checked' : '' }}>
                                <label for="course_{{ $cp->id }}" class="ml-2 text-gray-700">
                                    {{ $cp->course->subject_title }}
                                </label>
                            </div>
                            @endif
                            @endforeach
                            @else
                            <p class="text-gray-500 text-sm">No courses available for this program.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Section Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $section->name) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="max_students" class="block text-sm font-medium text-gray-700">Max Students</label>
                        <input type="number" name="max_students" id="max_students"
                            value="{{ old('max_students', $section->max_students) }}" required min="1"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="load_type" class="block text-sm font-medium text-gray-700">Load Type</label>
                        <select name="load_type" id="load_type" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="regular"
                                {{ (old('load_type', $section->load_type) == 'regular') ? 'selected' : '' }}>Regular
                            </option>
                            <option value="irregular"
                                {{ (old('load_type', $section->load_type) == 'irregular') ? 'selected' : '' }}>Irregular
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                            Update Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const programSelect = document.getElementById('program_id');
        const courseOptionsDiv = document.getElementById('course-options');

        // Function to load course programs for a selected program
        function loadCoursePrograms(programId) {
            courseOptionsDiv.innerHTML = '<p class="text-gray-500 text-sm">Loading courses...</p>';

            if (programId) {
                fetch(`/get-course-programs/${programId}`)
                    .then(response => response.json())
                    .then(data => {
                        courseOptionsDiv.innerHTML = '';

                        if (data.length === 0) {
                            courseOptionsDiv.innerHTML =
                                '<p class="text-red-500 text-sm">No courses found for this program.</p>';
                        } else {
                            // Get current selected course programs
                            const selectedCourseProgramIds = Array.from(
                                document.querySelectorAll('input[name="course_program_ids[]"]:checked')
                            ).map(el => parseInt(el.value));

                            data.forEach(courseProgram => {
                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.name = 'course_program_ids[]';
                                checkbox.value = courseProgram.id;
                                checkbox.id = 'course_' + courseProgram.id;

                                // Check if this course program was previously selected
                                if (selectedCourseProgramIds.includes(courseProgram.id)) {
                                    checkbox.checked = true;
                                }

                                const label = document.createElement('label');
                                label.htmlFor = checkbox.id;
                                label.classList = 'ml-2 text-gray-700';
                                label.textContent = courseProgram.course.subject_title;

                                const wrapper = document.createElement('div');
                                wrapper.className = 'flex items-center space-x-2';
                                wrapper.appendChild(checkbox);
                                wrapper.appendChild(label);

                                courseOptionsDiv.appendChild(wrapper);
                            });
                        }
                    })
                    .catch(error => {
                        courseOptionsDiv.innerHTML =
                            '<p class="text-red-500 text-sm">Error loading courses.</p>';
                        console.error('Error:', error);
                    });
            } else {
                courseOptionsDiv.innerHTML =
                    '<p class="text-gray-500 text-sm">Select a program to load courses.</p>';
            }
        }

        // Add event listener for program change
        programSelect.addEventListener('change', function() {
            loadCoursePrograms(this.value);
        });

        // Initialize with current program if set
        if (programSelect.value) {
            loadCoursePrograms(programSelect.value);
        }
    });
    </script>
    @endpush
</x-app-layout>