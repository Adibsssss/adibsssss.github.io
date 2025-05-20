<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgram extends Model
{
    use HasFactory;

    protected $table = 'course_program';

    protected $fillable = [
        'program_id',
        'course_id',
    ];

    // Relationship to Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship to Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Relationship to Sections through course_section table
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'course_section', 'course_program_id', 'section_id')
            ->withTimestamps();
    }
}