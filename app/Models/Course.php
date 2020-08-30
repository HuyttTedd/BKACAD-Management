<?php

namespace App\Models;
use App\Models\Major;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $keyType = 'string';

    protected $fillable = ['course_name'];

    public function majors(){
        return $this->belongsToMany(Major::class, 'course_majors');
    }

    public function classes()
    {
        return $this->belongsToMany(App\Models\Classes::class, 'class_courses');
    }

}
