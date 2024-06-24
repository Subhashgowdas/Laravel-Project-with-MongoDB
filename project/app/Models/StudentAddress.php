<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class StudentAddress extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'student_addresses';
    protected $fillable = ['phoneNumber', 'email', 'location', 'student_id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', '_id');
    }
}
