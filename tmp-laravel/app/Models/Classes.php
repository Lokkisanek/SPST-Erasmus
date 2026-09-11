<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function mobilities()
    {
        return $this->hasMany(Mobility::class, 'class_id');
    }
}