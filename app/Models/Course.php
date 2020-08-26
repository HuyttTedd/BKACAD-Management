<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = ['course_name'];

    public function majors(){
        return $this->belongsToMany(\App\Models\Major::class, 'course_majors');
    }

}
