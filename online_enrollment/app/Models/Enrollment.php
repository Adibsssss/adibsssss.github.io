<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'section_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the section that the student enrolled in.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}