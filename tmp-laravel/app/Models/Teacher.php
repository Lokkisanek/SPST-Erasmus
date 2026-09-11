<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classTeacherApplications()
    {
        return $this->hasMany(Application::class, 'class_teacher_id');
    }

    public function englishTeacherApplications()
    {
        return $this->hasMany(Application::class, 'english_teacher_id');
    }
}