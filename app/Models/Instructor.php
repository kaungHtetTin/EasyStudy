<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'category_instructor');
    }

    public function subscribers(){
        return $this->hasMany(Subscriber::class);
    }
}
