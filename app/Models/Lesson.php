<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function isLearned($user_id, $lesson_id){
        $history = LearningHistory::where('user_id',$user_id)->where('lesson_id',$lesson_id)->first();
        if($history) return true;
        else  return false;
    }
}
