<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(Request $req){
        $user = Auth::user();
        $req->validate([
            'course_id'=>'required|numeric',
        ]);
        
        $course_id = $req->course_id;
        $course = Course::find($course_id);

        if($course){
            if($course->instructor->user->id ==$user->id ){
                return view('instructor.course-question-and-answer',[
                    'page_title'=>'Q & A',
                    'course'=>$course,

                ]);
            }else{
                return redirect(route('instructor.error'));
            }
        }else{
            return redirect(route('instructor.error'));
        }
    }
}
