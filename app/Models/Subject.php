<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'id', 'subject_name', 'total_time', 'test_type'
    ];

    protected $keyType = 'string';

    public function classes()
    {
        return $this->belongsToMany(\App\Models\Classes::class);
    }

    public function students()
    {
        return $this->belongsToMany(\App\Models\Student::class);
    }

}
