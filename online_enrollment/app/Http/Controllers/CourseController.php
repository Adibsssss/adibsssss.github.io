<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(10);
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all(); 
        return view('course_schedules.create', compact('courses'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code,' . ($course->id ?? ''),
            'subject_title' => 'required|string',
            'units_lecture' => 'required|integer|min:0',
            'units_lab' => 'required|integer|min:0',
            'credit' => 'required|numeric|min:0',
            'program_id' => 'required|exists:programs,id',
        ]);
        

        $validated['user_id'] = Auth::id();

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:courses,code,' . ($course->id ?? ''),
            'subject_title' => 'required|string',
            'units_lecture' => 'required|integer|min:0',
            'units_lab' => 'required|integer|min:0',
            'credit' => 'required|numeric|min:0',
            'program_id' => 'required|exists:programs,id',
        ]);
        

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * Show the form to assign a teacher to a course.
     */
    public function showAssignTeacherForm(Course $course)
    {
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();

        return view('courses.assign_teacher', compact('course', 'teachers'));
    }

    /**
     * Assign a teacher to a course.
     */
    public function assignTeacher(Request $request, Course $course)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
        ]);

        $teacher = User::findOrFail($request->teacher_id);

        if (!$teacher->isTeacher()) {
            return back()->with('error', 'Selected user is not a teacher.');
        }

        $course->teachers()->syncWithoutDetaching([$teacher->id]);

        return back()->with('success', 'Teacher assigned to course successfully.');
    }
}