<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\User;
use App\Models\Program;
use App\Models\Enrollment;
use App\Models\CourseSchedule;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EnrollmentController extends Controller
{
    // Display the current student's enrollments
    public function myEnrollments()
    {
        $enrollments = Enrollment::with('section.coursePrograms.course', 'section.coursePrograms.program')
        ->where('user_id', Auth::id())
        ->get();  

        $availableSections = [];

        if ($enrollments->isEmpty()) {
            $availableSections = Section::withCount('enrollments')
                ->with(['program', 'course'])
                ->get()
                ->filter(fn($section) => $section->enrollments_count < $section->max_students);
        }

        return view('student.enrollments', compact('enrollments', 'availableSections'));
    }

    // Generate and display Certificate of Registration (COR) for a student
    public function generateCOR()
    {
        $user = Auth::user();

        $enrollments = Enrollment::with(['section.program', 'section', 'user'])->where('user_id', $user->id)->get();

        $programIds = $enrollments->pluck('section.program.id')->filter()->unique();

        // Collect all courses related to the enrolled programs
        $allCourses = Course::whereHas('programs', fn($query) => $query->whereIn('programs.id', $programIds))->with('programs')->get();

        foreach ($enrollments as $enrollment) {
            $section = $enrollment->section;
            if (!$section || !$section->program) continue;

            $programId = $section->program->id;
            $sectionName = $section->name;

            // Match course by section name containing course code
            $matchedCourse = $allCourses->first(fn($course) =>
                $course->programs->contains('id', $programId) &&
                stripos($sectionName, $course->code) !== false
            );

            // Fallback to first course in program
            if (!$matchedCourse) {
                $matchedCourse = $allCourses->first(fn($course) => $course->programs->contains('id', $programId));
            }

            $enrollment->course = $matchedCourse;

            // Get course teachers
            $enrollment->teachers = $matchedCourse
                ? \DB::table('course_teacher')
                    ->where('course_id', $matchedCourse->id)
                    ->join('users', 'users.id', '=', 'course_teacher.user_id')
                    ->pluck('users.name')
                    ->toArray()
                : [];

            // Get course schedules
            $enrollment->schedules = $matchedCourse
                ? CourseSchedule::where('course_id', $matchedCourse->id)->get()
                : collect();
        }

        // Unit calculations
        $totalLecUnits = $enrollments->sum(fn($e) => $e->course->units_lecture ?? 0);
        $totalLabUnits = $enrollments->sum(fn($e) => $e->course->units_lab ?? 0);
        $totalCredits = $enrollments->sum(fn($e) => $e->course->credit ?? 0);

        return view('student.cor', compact(
            'user',
            'enrollments',
            'totalLecUnits',
            'totalLabUnits',
            'totalCredits'
        ));
    }

    // Admin: display all enrollments
    public function allEnrollments()
    {
        $enrollments = Enrollment::with('section.program', 'section.course', 'user')
            ->orderBy('section_id')
            ->paginate(15);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    // Student self-enroll
    public function enroll($sectionId)
    {
        $section = Section::withCount('enrollments')->findOrFail($sectionId);

        if ($section->enrollments_count >= $section->max_students) {
            return back()->with('error', 'Section is already full.');
        }

        $alreadyEnrolled = Enrollment::where('user_id', Auth::id())
            ->where('section_id', $sectionId)
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('error', 'You are already enrolled in this section.');
        }

        Enrollment::create([
            'user_id' => Auth::id(),
            'section_id' => $sectionId,
        ]);

        return back()->with('success', 'Enrolled successfully!');
    }

    // Admin: form to enroll a student
    public function enrollStudentForm($sectionId = null)
    {
        $sections = Section::withCount('enrollments')->with(['program', 'course'])->get();

        // Get student IDs already enrolled in any section
        $enrolledStudentIds = Enrollment::pluck('user_id')->toArray();

        // Get only students who are NOT enrolled
        $students = User::whereHas('roles', fn($q) => $q->where('name', 'student'))
                        ->whereNotIn('id', $enrolledStudentIds)
                        ->get();

        $selectedSection = $sectionId ? Section::findOrFail($sectionId) : null;

        return view('admin.enrollments.create', compact('sections', 'students', 'selectedSection'));
    }


    // Admin: enroll student
    public function enrollStudent(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        $section = Section::withCount('enrollments')->findOrFail($request->section_id);

        if ($section->enrollments_count >= $section->max_students) {
            return back()->with('error', 'Section is already full.')->withInput();
        }

        $alreadyEnrolled = Enrollment::where('user_id', $request->user_id)
            ->where('section_id', $request->section_id)
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('error', 'Student is already enrolled in this section.')->withInput();
        }

        Enrollment::create([
            'user_id' => $request->user_id,
            'section_id' => $request->section_id,
        ]);

        return redirect()->route('admin.enrollments.index')->with('success', 'Student enrolled successfully!');
    }

    // Admin: view enrollments in a section
    public function sectionEnrollments($sectionId)
    {
        $section = Section::with(['program', 'course'])->findOrFail($sectionId);
        $enrollments = Enrollment::with('user')->where('section_id', $sectionId)->paginate(15);

        return view('admin.enrollments.section', compact('section', 'enrollments'));
    }

    // Admin: edit enrollment form
    public function edit(Enrollment $enrollment)
    {
        $sections = Section::with(['program', 'course'])->get();

        return view('admin.enrollments.edit', compact('enrollment', 'sections'));
    }

    // Admin: update enrollment
    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
        ]);

        $enrollment->section_id = $request->section_id;
        $enrollment->save();

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment section updated successfully.');
    }

    // Admin: remove enrollment
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }

    // Admin: download all enrollments as PDF
    public function download()
    {
        $enrollments = Enrollment::with('section.program', 'user')
            ->orderBy('section_id')
            ->get();

        $pdf = Pdf::loadView('admin.enrollments.pdf', compact('enrollments'));

        return $pdf->download('student-enrollments-' . now()->format('Y-m-d') . '.pdf');
    }
}