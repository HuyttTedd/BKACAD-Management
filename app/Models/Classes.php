<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = ['class_name'];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Student::class, 'class_students');
    }

    public function majors()
    {
        return $this->belongsToMany(\App\Models\Major::class, 'class_majors');
    }

    public function courses()
    {
        return $this->morphMany(\App\Models\Course::class, 'class_courses');
    }
}


