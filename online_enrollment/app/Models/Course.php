<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'subject_title',
        'units_lab',
        'units_lecture',
        'credit',
        'description',
    ];

    // Course belongs to user (creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Course has many schedules
    public function schedules()
    {
        return $this->hasMany(CourseSchedule::class);
    }

    public function teacher()
    {
        return $this->belongsToMany(User::class, 'course_teacher');
    }
    // Course has many teachers
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_teacher', 'course_id', 'user_id');
    }
    

    // Course belongs to many programs through course_program pivot
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'course_program', 'course_id', 'program_id')
            ->withTimestamps();
    }

    // Get sections that this course is associated with (through programs)
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'course_program')
            ->using(CourseProgram::class)  
            ->withTimestamps();
    }
}