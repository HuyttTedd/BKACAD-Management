<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $keyType = 'string';
    protected $fillable = [
        'lecturer_id', 'subject_id', 'date', 'time_start', 'time_end',
    ];
}
