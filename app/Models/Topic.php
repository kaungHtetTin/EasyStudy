<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function sub_category(){
        return $this->belongsTo(SubCategory::class);
    }
}
