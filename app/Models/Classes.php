<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = ['course_name'];

    public function students()
    {
        return $this->belongsToMany(\App\Models\Student::class);
    }
}
