<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Major;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classes extends Model
{
    protected $table = 'classes';
    protected $keyType = 'string';

    protected $fillable = ['class_name', 'course_id', 'major_id'];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Student::class, 'class_students');
    }

    public function majors()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // public function courses()
    // {
    //     return $this->morphMany(\App\Models\Course::class, 'class_courses');
    // }
}


