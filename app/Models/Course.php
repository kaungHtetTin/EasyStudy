<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function sub_category(){
        return $this->belongsTo(SubCategory::class);
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    public function modules(){
        return $this->hasMany(Module::class);
    }

    public function lessons(){
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function saved_courses(){
        return $this->hasMany(SavedCourse::class);
    }

    public function users(){
        return $this->belongsToMany(User::class,'saved_courses');
    }
    
}
