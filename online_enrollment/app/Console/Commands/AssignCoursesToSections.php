<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Section;
use App\Models\Course;
use App\Models\Program;

class AssignCoursesToSections extends Command
{
    protected $signature = 'app:assign-courses-to-sections';
    protected $description = 'Assign courses to sections based on program and section name';

    public function handle()
    {
        $this->info('Starting to assign courses to sections...');
        
        // Get all sections
        $sections = Section::with('program')->get();
        
        foreach ($sections as $section) {
            if (!$section->program) {
                $this->warn("Section #{$section->id} ({$section->name}) has no program assigned. Skipping.");
                continue;
            }
            
            $program = $section->program;
            $this->info("Processing section #{$section->id} ({$section->name}) from program {$program->name}");
            
            // Get all courses for this program
            $courses = Course::whereHas('programs', function ($query) use ($program) {
                $query->where('programs.id', $program->id);
            })->get();
            
            if ($courses->isEmpty()) {
                $this->warn("No courses found for program #{$program->id} ({$program->name}). Skipping section.");
                continue;
            }
            
            // Try to match by course code in the section name
            $matchedCourse = null;
            foreach ($courses as $course) {
                if (stripos($section->name, $course->code) !== false) {
                    $matchedCourse = $course;
                    $this->info("Matched course {$course->code} to section {$section->name} by code.");
                    break;
                }
            }
            
            // If no match was found, use the first course as fallback
            if (!$matchedCourse) {
                $matchedCourse = $courses->first();
                $this->warn("No exact match for section {$section->name}. Using {$matchedCourse->code} as fallback.");
            }
            
            // Now update the section with the course ID
            $section->course_id = $matchedCourse->id;
            $section->save();
            
            $this->info("Updated section #{$section->id} with course #{$matchedCourse->id} ({$matchedCourse->code})");
        }
        
        $this->info('Finished assigning courses to sections.');
        return 0;
    }
}