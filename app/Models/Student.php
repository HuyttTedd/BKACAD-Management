<?php

namespace App\Models;
use App\Models\Classes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'fullname', 'dob', 'gender', 'phone', 'email', 'password', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $keyType = 'string';

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'class_students');
    }

}
