<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeacherAssignmentController extends Controller
{
    /**
     * Show the form to assign teachers to courses.
     */
    public function create()
    {
        return view('assigned-teacher.create');
    }
    
    /**
     * Display the assign teacher form.
     */
    public function showAssignTeacherForm()
    {
        $courses = Course::all();
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();

        return view('assigned-teacher.create', compact('courses', 'teachers'));
    }

    /**
     * Show the dashboard for teacher assignments.
     */
    public function index()
    {
        return redirect()->route('assigned.teachers.list');
    }

    /**
     * Assign the teacher to the course.
     */
    public function assignTeacher(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id', 
            'course_id' => 'required|exists:courses,id', 
        ]);

        $course = Course::findOrFail($request->course_id);
        $teacher = User::findOrFail($request->teacher_id);

        if ($course->teachers->contains($teacher)) {
            return redirect()->back()->with('error', 'This teacher is already assigned to the course.');
        }
        
        $course->teachers()->attach($teacher);

        return redirect()->route('assigned.teachers.list')->with('success', 'Teacher assigned successfully!');
    }

    /**
     * Show the list of assigned teachers to courses.
     */
    public function showAssignedTeachers()
    {
        $courses = Course::with('teachers')->paginate(10); 

        return view('assigned-teacher.list', compact('courses'));
    }

    /**
     * Remove the teacher from the course.
     */
    public function removeTeacher($courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->teachers()->detach(); 

        return redirect()->route('assigned.teachers.list')->with('success', 'Teacher removed successfully.');
    }
    public function removeSingleTeacher($courseId, $teacherId)
    {
        $course = Course::findOrFail($courseId);
        $course->teachers()->detach($teacherId);

        return redirect()->back()->with('success', 'Teacher removed successfully.');
    }

    public function edit(Course $course)
    {
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();

        return view('assigned-teacher.edit', compact('course', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'teacher_ids' => 'array|required',
            'teacher_ids.*' => 'exists:users,id',
        ]);

        $course->teachers()->sync($request->teacher_ids); // replaces existing assignments

        return redirect()->route('assigned.teachers.list')->with('success', 'Teacher assignments updated successfully!');
    }

    public function replaceTeacher(Request $request, Course $course)
    {
        $request->validate([
            'old_teacher_id' => 'required|exists:users,id',
            'new_teacher_id' => 'required|exists:users,id|different:old_teacher_id',
        ]);

        if (!$course->teachers->contains($request->old_teacher_id)) {
            return back()->withErrors(['old_teacher_id' => 'The selected old teacher is not assigned to this course.']);
        }

        $course->teachers()->detach($request->old_teacher_id);
        $course->teachers()->attach($request->new_teacher_id);

        return back()->with('success', 'Teacher replaced successfully.');
    }

    
    public function teacherDashboard()
    {
        $user = auth()->user();
        
        $courses = Course::whereHas('teacher', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['programs.sections', 'schedules'])
            ->get();
        
        return view('teacher.dashboard', compact('courses'));
    }
}