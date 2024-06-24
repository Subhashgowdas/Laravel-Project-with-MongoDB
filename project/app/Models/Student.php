<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Student extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'students';
    protected $fillable = ['name', 'rollNumber', 'branch', 'college'];

    public function address()
    {
        return $this->hasOne(StudentAddress::class, 'student_id', '_id');
    }
}
