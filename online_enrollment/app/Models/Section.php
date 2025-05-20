<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'name',
        'max_students',
        'load_type', 
    ];

    // Relationship to Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Relationship with course programs through course_section pivot table
    public function coursePrograms()
    {
        return $this->belongsToMany(CourseProgram::class, 'course_section', 'section_id', 'course_program_id')
            ->withTimestamps();
    }
    // app/Models/Section.php
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Get courses for this section via course_programs
    public function courses()
    {
        return Course::whereHas('programs.sections', function($query) {
            $query->where('sections.id', $this->id);
        });
    }

    // Enrollments for this section
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Students enrolled in this section
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'section_id', 'user_id');
    }

    public function isRegular()
    {
        return $this->load_type === 'regular';
    }

    public function isIrregular()
    {
        return $this->load_type === 'irregular';
    }
}