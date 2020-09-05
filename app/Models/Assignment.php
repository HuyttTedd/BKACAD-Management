<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'assignments';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'class_id', 'subject_id', 'lecturer_id', 'status'
    ];
    // public function classes() {
    //     return $this->hasMany(Classes::class, 'course_id');
    // }

    protected $primaryKey = ['class_id', 'subject_id'];
}
