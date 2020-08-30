<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'class_students';
    protected $keyType = 'string';
    protected $fillable = [
        'class_id', 'student_id',
    ];
    public $timestamps = false;
}
