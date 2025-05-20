<?php
namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs
     */
    public function index()
    {
        $programs = Program::with('courses')->paginate(10); 

        return view('program.index', compact('programs')); 
    }

    public function getCourses(Program $program)
    {
        return response()->json($program->courses()->select('id', 'code', 'name')->get());
    }

    /**
     * Show form for creating a new program
     */
    public function create()
    {
        $courses = Course::all(); 
        return view('program.create', compact('courses'));
    }

    /**
     * Store a newly created program
     */

     public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:programs',
            'year_level' => 'required|integer|min:1|max:5',
            'semester' => 'required|integer|min:1|max:2',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);

        $program = Program::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'year_level' => $validated['year_level'],
            'semester' => $validated['semester'],
        ]);

        if (!empty($validated['courses'])) {
            $program->courses()->attach($validated['courses']);
        }

        return redirect()->route('program.index')->with('success', 'Program created successfully.');
    }

    /**
     * Display the specified program
     */
    public function show(Program $program)
    {
        $courses = $program->courses()
            ->orderBy('pivot_year_level')
            ->orderBy('pivot_semester')
            ->paginate(10); 

        return view('program.show', compact('program', 'courses'));
    }


    /**
     * Show form for editing program
     */
    public function edit(Program $program)
    {
        $courses = Course::all();
        return view('program.edit', compact('program', 'courses'));
    }
    

    /**
     * Update the specified program
     */
    
     public function update(Request $request, Program $program)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'code' => 'required|string|unique:programs,code,' . $program->id,
             'year_level' => 'required|integer|min:1|max:5',
             'semester' => 'required|integer|min:1|max:2',
             'courses' => 'nullable|array',
             'courses.*' => 'exists:courses,id',
         ]);

         $program->update([
             'name' => $validated['name'],
             'code' => $validated['code'],
             'year_level' => $validated['year_level'],
             'semester' => $validated['semester'],
         ]);
     
         if ($request->has('courses')) {
             $program->courses()->sync($validated['courses']);
         }
     
         return redirect()->route('program.index')->with('success', 'Program updated successfully');
     }
     
    /**
     * Remove the specified program
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect('/program')->with('success', 'Program deleted successfully.');
    }
}