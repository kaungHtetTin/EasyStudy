<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }
}
