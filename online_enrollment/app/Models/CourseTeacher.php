<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    use HasFactory;

    protected $table = 'course_teacher';

    protected $fillable = [
        'user_id',
        'course_id',
    ];

    /**
     * Get the course that this teaching assignment belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user (teacher) that owns this teaching assignment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}