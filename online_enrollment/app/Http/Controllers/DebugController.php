<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Section;
use App\Models\CourseTeacher;
use App\Models\CourseSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebugController extends Controller
{
    /**
     * Debug relationships for Certificate of Registration.
     *
     * @return \Illuminate\Http\Response
     */
    public function debugCertificate()
    {
        // Get the authenticated user (student)
        $student = Auth::user();
        
        // Check if the user has the student role
        $hasStudentRole = $student->hasRole('student');
        
        // Get all enrollments for this student
        $enrollments = Enrollment::where('user_id', $student->id)->get();
        
        // Debug data collection
        $debugData = [
            'user_id' => $student->id,
            'user_name' => $student->name,
            'has_student_role' => $hasStudentRole,
            'enrollment_count' => $enrollments->count(),
            'enrollments' => []
        ];
        
        // Collect data for each enrollment
        foreach ($enrollments as $enrollment) {
            $section = Section::find($enrollment->section_id);
            $course = $section ? Course::find($section->course_id) : null;
            
            $enrollmentData = [
                'enrollment_id' => $enrollment->id,
                'section_id' => $enrollment->section_id,
                'section_exists' => $section ? true : false,
                'section_name' => $section ? $section->name : 'N/A',
                'course_id' => $section ? $section->course_id : null,
                'course_exists' => $course ? true : false,
            ];
            
            if ($course) {
                $schedules = CourseSchedule::where('course_id', $course->id)->get();
                $teachers = CourseTeacher::where('course_id', $course->id)->with('user')->get();
                
                $enrollmentData['course_data'] = [
                    'code' => $course->code,
                    'subject_title' => $course->subject_title,
                    'units_lecture' => $course->units_lecture,
                    'units_lab' => $course->units_lab,
                    'credit' => $course->credit,
                    'schedule_count' => $schedules->count(),
                    'schedules' => $schedules->map(function($schedule) {
                        return [
                            'day_of_week' => $schedule->day_of_week,
                            'start_time' => $schedule->start_time,
                            'end_time' => $schedule->end_time
                        ];
                    }),
                    'teacher_count' => $teachers->count(),
                    'teachers' => $teachers->map(function($teacher) {
                        return [
                            'user_id' => $teacher->user_id,
                            'teacher_name' => $teacher->user ? $teacher->user->name : 'N/A'
                        ];
                    })
                ];
            }
            
            $debugData['enrollments'][] = $enrollmentData;
        }
        
        return response()->json($debugData);
    }
}