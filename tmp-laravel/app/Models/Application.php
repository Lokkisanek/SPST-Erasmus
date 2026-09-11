<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function mobility()
    {
        return $this->belongsTo(Mobility::class);
    }

    public function classTeacher()
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

    public function englishTeacher()
    {
        return $this->belongsTo(Teacher::class, 'english_teacher_id');
    }
}