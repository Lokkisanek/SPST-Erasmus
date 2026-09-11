<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobility extends Model
{
    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}