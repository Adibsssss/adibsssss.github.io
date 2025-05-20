<?php

use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\CourseScheduleController;
use App\Http\Controllers\TeacherAssignmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Student specific route
    Route::prefix('student')->group(function () {
        Route::get('/enrollments', function () {
            return view('student.enrollments');
        })->name('student.enrollments');
    });
    
    Route::prefix(prefix: 'teacher')->group(function () {
        Route::get('/teacher/dashboard', [TeacherAssignmentController::class, 'teacherDashboard'])->name('teacher.dashboard');
    });
});
// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
    Route::post('/profile/avatar', [ProfileController::class, 'upload'])->name('profile.upload')->middleware('auth');

    Route::get('/sections', [EnrollmentController::class, 'index'])->name('sections.index');
    Route::get('/sections', [EnrollmentController::class, 'edit'])->name('sections.edit');
    Route::post('/sections/enroll/{sectionId}', [EnrollmentController::class, 'enroll'])->name('sections.enroll');

    Route::get('/student', [EnrollmentController::class, 'myEnrollments'])->name('student.enrollments');
    Route::get('/my-enrollments', [EnrollmentController::class, 'myEnrollments'])->name('student.enrollments');
    Route::post('/enroll/{sectionId}', [EnrollmentController::class, 'enroll'])->name('student.enroll');
    Route::get('/cor', [EnrollmentController::class, 'generateCOR'])->name('student.cor');
    Route::get('/certificate/registration', action: [CertificateController::class, 'show'])
    ->name('certificate.registration');
    Route::get('/debug/certificate', [App\Http\Controllers\DebugController::class, 'debugCertificate'])->middleware('auth');
});


// Admin-only routes for user management
Route::middleware(['auth', 'is_admin'])->group(function () {
    // Course management routes
    Route::resource('courses', CourseController::class);

    // Teacher assignment routes with consistent naming
    Route::get('/teacher-assignment', [TeacherAssignmentController::class, 'index'])->name('assigned.teachers');
    Route::get('/assigned-teachers/list', [TeacherAssignmentController::class, 'showAssignedTeachers'])->name('assigned.teachers.list');
    Route::get('/assign-teacher', [TeacherAssignmentController::class, 'showAssignTeacherForm'])->name('assign.teacher.form');
    Route::post('/assign-teacher', [TeacherAssignmentController::class, 'assignTeacher'])->name('assign.teacher');
    Route::delete('/remove-teacher/{course}', [TeacherAssignmentController::class, 'removeTeacher'])->name('remove.teacher');
    Route::get('/assign-teacher/edit/{course}', [TeacherAssignmentController::class, 'edit'])->name('assign.teacher.edit');
    Route::put('/assign-teacher/update/{course}', [TeacherAssignmentController::class, 'update'])->name('assign.teacher.update');
    Route::delete('/assign/teacher/{course}/{teacher}', [TeacherAssignmentController::class, 'removeSingleTeacher'])->name('remove.single.teacher');
    Route::put('/assign-teacher/replace/{course}', [TeacherAssignmentController::class, 'replaceTeacher'])->name('assign.teacher.replace');
    
    // User management routes
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');

    // Course Schedule Management
    Route::get('/course_schedules', [CourseScheduleController::class, 'index'])->name('course_schedules.index');
    Route::get('/course_schedules/create', [CourseScheduleController::class, 'create'])->name('course_schedules.create');
    Route::post('/course_schedules', [CourseScheduleController::class, 'store'])->name('course_schedules.store');
    Route::get('/course_schedules/{courseSchedule}/edit', [CourseScheduleController::class, 'edit'])->name('course_schedules.edit');
    Route::put('/course_schedules/{courseSchedule}', [CourseScheduleController::class, 'update'])->name('course_schedules.update');
    Route::delete('/course_schedules/{courseSchedule}', [CourseScheduleController::class, 'destroy'])->name('course_schedules.destroy');

    // Program routes
    Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
    Route::get('/program/create', [ProgramController::class, 'create'])->name('program.create');
    Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
    Route::get('/program/{program}', [ProgramController::class, 'show'])->name('program.show');
    Route::get('/program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit');
    Route::put('/program/{program}', [ProgramController::class, 'update'])->name('program.update');
    Route::delete('/program/{program}', [ProgramController::class, 'destroy'])->name('program.destroy');

    // Section Routes
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::get('/get-course-programs/{program_id}', [SectionController::class, 'getCoursePrograms']);

    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

    // Enrollment management
    Route::get('enrollments', [EnrollmentController::class, 'allEnrollments'])->name('admin.enrollments.index');
    Route::get('/admin/enrollments/create', [EnrollmentController::class, 'enrollStudentForm'])->name('admin.enrollments.create');
    Route::post('enrollments', [EnrollmentController::class, 'enrollStudent'])->name('admin.enrollments.store');
    Route::delete('enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('admin.enrollments.destroy');
    Route::get('enrollments/{enrollment}/edit', [EnrollmentController::class, 'edit'])->name('admin.enrollments.edit');
    Route::put('enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('admin.enrollments.update');
    Route::get('/admin/enrollments/download', [EnrollmentController::class, 'download'])->name('admin.enrollments.download');
    Route::get('/certificate/registration/{user}', [CertificateController::class, 'showForStudent'])
    ->name('certificate.registration.student')
    ->middleware('can:view-student-certificate');

});

require __DIR__.'/auth.php';