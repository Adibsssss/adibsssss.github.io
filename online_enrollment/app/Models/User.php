<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;  

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password','profile_picture', 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRole($roles)
    {
        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        return $this->roles->whereIn('name', $roles)->count() > 0;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher');
    }
    
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
    
    /**
     * Check if the user is a student.
     */
    public function isStudent()
    {
        return $this->hasRole('student');
    }
    
    /**
     * Check if the user is a teacher.
     */
    public function isTeacher()
    {
        return $this->hasRole('teacher');
    }
    
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class);
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'enrollments', 'user_id', 'section_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledSections()
    {
        return $this->belongsToMany(Section::class, 'enrollments');
    }

    public function teaching()
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'user_id', 'course_id');
    }
    
    public function teachingAssignments()
    {
        return $this->hasMany(CourseTeacher::class);
    }
    
    public function teachingCourses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'user_id', 'course_id');
    }
    
    public function assignedCourses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher');
    }
}