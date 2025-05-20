<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseSection extends Pivot
{
    use HasFactory;

    protected $table = 'course_section';

    protected $fillable = [
        'section_id',
        'course_program_id',
    ];

    // Get the course program this record belongs to
    public function courseProgram()
    {
        return $this->belongsTo(CourseProgram::class, 'course_program_id');
    }

    // Get the section this record belongs to
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}