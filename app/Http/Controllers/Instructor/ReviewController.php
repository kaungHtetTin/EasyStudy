<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $req){
        $user = Auth::user();
        $course_id = $req->course_id;
        $course = Course::find($course_id);

        if($course){
            if($course->instructor->user->id ==$user->id ){
                return view('instructor.course-reviews',[
                    'page_title'=>'Reviews',
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
