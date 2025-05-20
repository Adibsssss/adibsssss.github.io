<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'year_level', 'semester'
    ];

    /**
     * Get the courses for the program.
     */
    // In Program.php
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_program')->withTimestamps();
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function enrollments()
    {
        return $this->hasManyThrough(
            Enrollment::class,  
            Course::class,      
            'program_id',      
            'course_id',       
            'id',              
            'id'               
        );
    }
}