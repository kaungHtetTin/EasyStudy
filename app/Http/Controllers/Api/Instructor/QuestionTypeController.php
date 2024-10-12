<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\QuestionType;
use App\Models\Instructor;

class QuestionTypeController extends Controller
{
    public function store(Request $request){
        $user = $request->user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        $validatedData = $request->validate([
            'title'=>'required',
            'course_id'=>'required|numeric',
        ]);

        
        $course_id = $request->course_id;
        $title = $request->title;

        $course = Course::find($course_id);
        if($course==null){
            return response()->json(['status'=>'fail','message'=>'Bad request'],400);
        }

        if($course->instructor_id!= $instructor->id){
            return response()->json(['status'=>'fail','message'=>'Forbidden'],403);
        }

        $question_type = new QuestionType();
        $question_type->title = $title;
        $question_type->course_id = $course_id;
        $question_type->save();

        

        return response()->json($question_type, 200);
    
    }
}
