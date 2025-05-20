<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CourseScheduleController extends Controller
{
    /**
     * Display a listing of the course's schedules.
     */
    public function index()
    {
        $schedules = CourseSchedule::with('course')->paginate(10);

        // Format start and end times
        foreach ($schedules as $schedule) {
            $schedule->start_time = Carbon::parse($schedule->start_time)->format('h:i A');
            $schedule->end_time = Carbon::parse($schedule->end_time)->format('h:i A');
        }
        
        return view('course_schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create(Course $course)
    {
        // Fetch all courses to display in the dropdown
        $courses = Course::all();

        // Pass the current course and all courses to the view
        return view('course_schedules.create', compact('courses', 'course'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A|after:start_time',
        ]);
    
        // Convert start and end time to proper format
        $start_time = Carbon::createFromFormat('h:i A', $validated['start_time'])->format('H:i:s');
        $end_time = Carbon::createFromFormat('h:i A', $validated['end_time'])->format('H:i:s');
    
        // Create and save the new course schedule
        $schedule = new CourseSchedule([
            'course_id' => $validated['course_id'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $start_time,
            'end_time' => $end_time,
        ]);
    
        $schedule->save();
    
        return redirect()->route('course_schedules.index')->with('success', 'Course schedule created successfully!');
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(CourseSchedule $courseSchedule)
    {
        // Fetch all courses to display in the dropdown
        $courses = Course::all();

        // Pass the schedule and courses to the view
        return view('course_schedules.edit', compact('courseSchedule', 'courses'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, CourseSchedule $courseSchedule)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|string|max:20',
            'start_time'  => 'required|date_format:h:i A',
            'end_time'    => 'required|date_format:h:i A|after:start_time',
        ]);

        if (isset($validated['start_time'])) {
            $validated['start_time'] = Carbon::createFromFormat('h:i A', $validated['start_time'])->format('H:i:s');
        }
        
        if (isset($validated['end_time'])) {
            $validated['end_time'] = Carbon::createFromFormat('h:i A', $validated['end_time'])->format('H:i:s');
        }

        $courseSchedule->update($validated);

        return redirect()
            ->route('course_schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(CourseSchedule $courseSchedule)
    {
        $courseId = $courseSchedule->course_id;

        // Delete the schedule
        $courseSchedule->delete();

        // Redirect to the schedule index with success message
        return redirect()
            ->route('course_schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}