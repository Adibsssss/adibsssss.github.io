<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-lg font-semibold mb-2">Total Students</div>
                    <div class="text-3xl" id="total-students">{{ $totalStudents }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-lg font-semibold mb-2">Total Courses</div>
                    <div class="text-3xl" id="total-courses">{{ $totalCourses }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-lg font-semibold mb-2">Total Programs</div>
                    <div class="text-3xl" id="total-programs">{{ $totalPrograms }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-lg font-semibold mb-2">Total Teachers</div>
                    <div class="text-3xl" id="total-teachers">{{ $totalTeachers }}</div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Enrollments by Program Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Enrollments by Program</h3>
                    <div class="h-80">
                        <canvas id="enrollments-by-program"></canvas>
                    </div>
                </div>

                <!-- Courses by Credit Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Courses by Credit</h3>
                    <div class="h-80">
                        <canvas id="courses-by-credit"></canvas>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Course Schedule Distribution -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Course Schedule Distribution</h3>
                    <div class="h-80">
                        <canvas id="course-schedule-distribution"></canvas>
                    </div>
                </div>

                <!-- Section Capacity Utilization -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Section Capacity Utilization</h3>
                    <div class="h-80">
                        <canvas id="section-capacity"></canvas>
                    </div>
                </div>
            </div>

            <!-- Charts Row 3 -->
            <div class="grid grid-cols-1 gap-6">
                <!-- Teacher Course Load -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Teacher Course Load</h3>
                    <div class="h-80">
                        <canvas id="teacher-course-load"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enrollments by Program Chart - Modified to handle long labels
            new Chart(document.getElementById('enrollments-by-program'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($enrollmentsByProgram->pluck('name')) !!},
                    datasets: [{
                        label: 'Number of Students',
                        data: {!! json_encode($enrollmentsByProgram->pluck('count')) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Change to horizontal bar chart
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                        y: {
                            ticks: {
                                callback: function(value) {
                                    // Truncate long program names
                                    const label = this.getLabelForValue(value);
                                    if (label.length > 25) {
                                        return label.substr(0, 22) + '...';
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    // Show full program name in tooltip
                                    return tooltipItems[0].label;
                                }
                            }
                        }
                    }
                }
            });

            // Courses by Credit Chart
            new Chart(document.getElementById('courses-by-credit'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($coursesByCredit->pluck('credit_label')) !!},
                    datasets: [{
                        data: {!! json_encode($coursesByCredit->pluck('count')) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Course Schedule Distribution
            new Chart(document.getElementById('course-schedule-distribution'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($scheduleDistribution->pluck('day_of_week')) !!},
                    datasets: [{
                        data: {!! json_encode($scheduleDistribution->pluck('count')) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(199, 199, 199, 0.6)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            // Section Capacity Utilization
            new Chart(document.getElementById('section-capacity'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($sectionCapacity->pluck('name')) !!},
                    datasets: [{
                        label: 'Current Students',
                        data: {!! json_encode($sectionCapacity->pluck('current_students')) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Maximum Capacity',
                        data: {!! json_encode($sectionCapacity->pluck('max_students')) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Teacher Course Load
            new Chart(document.getElementById('teacher-course-load'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($teacherCourseLoad->pluck('name')) !!},
                    datasets: [{
                        label: 'Number of Courses',
                        data: {!! json_encode($teacherCourseLoad->pluck('course_count')) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>