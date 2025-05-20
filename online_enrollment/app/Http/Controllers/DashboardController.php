<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary counts
        $totalStudents = User::whereHas('roles', function($query) {
            $query->where('name', 'student');
        })->count();
        
        $totalCourses = Course::count();
        $totalPrograms = Program::count();
        
        $totalTeachers = User::whereHas('roles', function($query) {
            $query->where('name', 'teacher');
        })->count();
        
        // Enrollments by Program
        $enrollmentsByProgram = Program::select('programs.name', DB::raw('COUNT(enrollments.id) as count'))
            ->leftJoin('sections', 'programs.id', '=', 'sections.program_id')
            ->leftJoin('enrollments', 'sections.id', '=', 'enrollments.section_id')
            ->groupBy('programs.id', 'programs.name')
            ->orderBy('count', 'desc')
            ->get();
        
        // Courses by Credit
        $coursesByCredit = Course::select(
            DB::raw('CASE 
                WHEN credit = 0 THEN "No Credit" 
                WHEN credit <= 1 THEN "1 Credit" 
                WHEN credit <= 2 THEN "2 Credits" 
                WHEN credit <= 3 THEN "3 Credits" 
                ELSE "4+ Credits" 
            END as credit_label'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('credit_label')
        ->orderBy('count', 'desc')
        ->get();
        
        // Course Schedule Distribution
        $scheduleDistribution = DB::table('course_schedules')
            ->select('day_of_week', DB::raw('COUNT(*) as count'))
            ->groupBy('day_of_week')
            ->orderBy('count', 'desc')
            ->get();
        
        // Section Capacity Utilization
        $sectionCapacity = Section::select(
                'sections.name',
                'sections.max_students',
                DB::raw('COUNT(enrollments.id) as current_students')
            )
            ->leftJoin('enrollments', 'sections.id', '=', 'enrollments.section_id')
            ->groupBy('sections.id', 'sections.name', 'sections.max_students')
            ->orderBy('current_students', 'desc')
            ->limit(10)
            ->get();
        
        // Teacher Course Load
        $teacherCourseLoad = User::select('users.name', DB::raw('COUNT(course_teacher.course_id) as course_count'))
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->leftJoin('course_teacher', 'users.id', '=', 'course_teacher.user_id')
            ->where('roles.name', 'teacher')
            ->groupBy('users.id', 'users.name')
            ->orderBy('course_count', 'desc')
            ->limit(15)
            ->get();
        
        return view('dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalPrograms',
            'totalTeachers',
            'enrollmentsByProgram',
            'coursesByCredit',
            'scheduleDistribution',
            'sectionCapacity',
            'teacherCourseLoad'
        ));
    }
}