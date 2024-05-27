<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function instructors(){
        return $this->belongsToMany(Instructor::class,'category_instructor');
    }
}
