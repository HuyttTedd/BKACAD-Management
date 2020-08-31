<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasCompositePrimaryKey;
    protected $keyType = 'string';
    protected $fillable = [
        'attendance_id', 'student_id', 'class_id', 'status',
    ];


    protected $primaryKey = ['attendance_id', 'student_id'];
}
