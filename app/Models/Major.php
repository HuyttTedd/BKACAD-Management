<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'majors';

    protected $keyType = 'string';

    protected $fillable = ['id', 'major_name'];

    public function courses(){
        return $this->belongsToMany(\App\Models\Course::class, 'course_majors');
    }

    public function subjects(){
        return $this->belongsToMany(\App\Models\Subject::class, 'major_subjects');
    }

    public function classesGroup(){
        return $this->belongsToMany(\App\Models\Classes::class, 'class_course_majors')
        ->using(\App\Models\Course::class)->withPivot('course_id');
    }
}
