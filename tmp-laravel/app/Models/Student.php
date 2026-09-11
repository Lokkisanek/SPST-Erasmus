<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function schoolClass() {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }
}
