<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Program;
use App\Models\CourseProgram;
use App\Models\Course;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        // Changed courseProgram to coursePrograms (plural)
        $sections = Section::with(['coursePrograms.course', 'coursePrograms.program'])->paginate(10);
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        $programs = Program::all();
        $coursePrograms = CourseProgram::with(['program', 'course'])->get();
        return view('sections.create', compact('programs', 'coursePrograms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'course_program_ids' => 'required|array',
            'course_program_ids.*' => 'exists:course_program,id',
            'name' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1',
            'load_type' => 'required|string|in:regular,irregular',
        ]);
    
        // Create one Section record only
        $section = Section::create([
            'program_id' => $request->program_id,
            'name' => $request->name,
            'max_students' => $request->max_students,
            'load_type' => $request->load_type,
        ]);
    
        // Attach multiple courses to that section
        $section->coursePrograms()->attach($request->course_program_ids);
    
        return redirect()->route('sections.index')->with('success', 'Section created successfully with courses.');
    }
    
    public function edit(Section $section)
    {
        $programs = Program::all(); // Add this line to pass programs to the view
        $coursePrograms = CourseProgram::with(['course', 'program'])->get();
        // Load the section's current course programs
        $section->load('coursePrograms');
        return view('sections.edit', compact('section', 'coursePrograms', 'programs'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'name' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1',
            // Add load_type validation if needed
            'load_type' => 'sometimes|string|in:regular,irregular',
            // Add course_program_ids validation if you want to update courses
            'course_program_ids' => 'sometimes|array',
            'course_program_ids.*' => 'exists:course_program,id',
        ]);

        $section->update([
            'program_id' => $request->program_id,
            'name' => $request->name,
            'max_students' => $request->max_students,
            'load_type' => $request->input('load_type', $section->load_type), // Keep current if not provided
        ]);

        // Update the course programs if they're provided
        if ($request->has('course_program_ids')) {
            $section->coursePrograms()->sync($request->course_program_ids);
        }

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }
    
    public function getCoursePrograms($program_id)
    {
        $coursePrograms = CourseProgram::with('course')
            ->where('program_id', $program_id)
            ->get();

        return response()->json($coursePrograms);
    }  
    
    public function getCourses($programId)
    {
        $coursePrograms = CourseProgram::with('course') 
            ->where('program_id', $programId)
            ->get();

        return response()->json($coursePrograms);
    }

    public function showEnrollments(Section $section)
    {
        // Changed courseProgram to coursePrograms (plural)
        $section->load(['enrollments.user', 'coursePrograms.course', 'coursePrograms.program']);
        return view('sections.enrollments', compact('section'));
    }

    public function destroy(Section $section)
    {
        // Detach related course programs before deletion
        $section->coursePrograms()->detach();
        $section->delete();
        
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }

    public function associateCourseWithSection($sectionId, $course_program)
    {
        $section = Section::findOrFail($sectionId);
        $courseProgram = CourseProgram::findOrFail($course_program);

        \DB::table('course_section')->insert([
            'section_id' => $sectionId,
            'course_program_id' => $course_program,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Course associated with section successfully');
    }
}