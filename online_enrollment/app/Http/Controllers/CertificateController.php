<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\CourseProgram;
use App\Models\CourseSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    /**
     * Display the Certificate of Registration for the current student.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Get the authenticated user (student)
        $student = Auth::user();
        
        // Ensure the user is a student
        if (!$student->hasRole('student')) {
            return redirect()->route('dashboard')->with('error', 'Only students can access their Certificate of Registration.');
        }
        
        // Get all enrollments for this student
        $enrollments = Enrollment::where('user_id', $student->id)
            ->with('section')
            ->get();
            
        // Prepare data for the view
        $enrollmentData = [];
        $totalLecUnits = 0;
        $totalLabUnits = 0;
        $totalCredits = 0;
        
        foreach ($enrollments as $enrollment) {
            // Get section ID
            $sectionId = $enrollment->section_id;
            
            // Get course programs associated with this section
            $coursePrograms = DB::table('course_section')
                ->where('section_id', $sectionId)
                ->join('course_program', 'course_section.course_program_id', '=', 'course_program.id')
                ->select('course_program.course_id', 'course_program.program_id')
                ->get();
                
            foreach ($coursePrograms as $cp) {
                // Get course details
                $course = Course::with(['schedules', 'teachers'])->find($cp->course_id);

                if ($course) {
                    // Add to enrollment data
                    $enrollmentData[] = [
                        'enrollment' => $enrollment,
                        'course' => $course
                    ];
                    
                    // Add to totals
                    $totalLecUnits += $course->units_lecture;
                    $totalLabUnits += $course->units_lab;
                    $totalCredits += $course->credit;
                }
            }
        }
        
        return view('certificate.registration', compact(
            'student', 
            'enrollmentData', 
            'totalLecUnits', 
            'totalLabUnits', 
            'totalCredits'
        ));
    }
    
    /**
     * Display the Certificate of Registration for a specific student (admin access).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForStudent($id)
    {
        // Check if current user has admin or registrar role
        if (!Auth::user()->hasRole(['admin', 'registrar'])) {
            return abort(403, 'Unauthorized action.');
        }
        
        // Get the student
        $student = User::findOrFail($id);
        
        // Ensure the user is a student
        if (!$student->hasRole('student')) {
            return redirect()->route('admin.users.index')->with('error', 'Selected user is not a student.');
        }
        
        // Get all enrollments for this student
        $enrollments = Enrollment::where('user_id', $student->id)
            ->with('section')
            ->get();
            
        // Prepare data for the view
        $enrollmentData = [];
        $totalLecUnits = 0;
        $totalLabUnits = 0;
        $totalCredits = 0;
        
        foreach ($enrollments as $enrollment) {
            // Get section ID
            $sectionId = $enrollment->section_id;
            
            // Get course programs associated with this section
            $coursePrograms = DB::table('course_section')
                ->where('section_id', $sectionId)
                ->join('course_program', 'course_section.course_program_id', '=', 'course_program.id')
                ->select('course_program.course_id', 'course_program.program_id')
                ->get();
                
            foreach ($coursePrograms as $cp) {
                // Get course details
                $course = Course::with(['schedules', 'teachers.user'])
                    ->find($cp->course_id);
                    
                if ($course) {
                    // Add to enrollment data
                    $enrollmentData[] = [
                        'enrollment' => $enrollment,
                        'course' => $course
                    ];
                    
                    // Add to totals
                    $totalLecUnits += $course->units_lecture;
                    $totalLabUnits += $course->units_lab;
                    $totalCredits += $course->credit;
                }
            }
        }
        
        return view('certificate.registration', compact(
            'student', 
            'enrollmentData', 
            'totalLecUnits', 
            'totalLabUnits', 
            'totalCredits'
        ));
    }
}