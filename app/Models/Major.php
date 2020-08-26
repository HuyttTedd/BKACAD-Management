<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'majors';

    protected $keyType = 'string';

    protected $fillable = ['id', 'major_name'];

    public function coures(){
        return $this->belongsToMany(\App\Models\Course::class, 'course_majors');
    }

    public function subjects(){
        return $this->belongsToMany(\App\Models\Subject::class);
    }

    public function classes(){
        return $this->belongsToMany(\App\Models\Classes::class);
    }
}
