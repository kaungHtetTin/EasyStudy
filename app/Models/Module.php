<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    use HasFactory;
    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

    public function mLessons($user_id){
        $lessons = Lesson::select([
            '*',
            \DB::raw("CASE WHEN EXISTS (SELECT NULL FROM learning_histories lh 
                    WHERE lh.user_id =$user_id AND lh.lesson_id = lessons.id) THEN 1 ELSE 0 END as learned")
        ])->where('module_id',$this->id)->get();
        return $lessons;
    }

    
}
