<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;
use App\Models\PaymentMethod;
use App\Models\Course;
use App\Models\PaymentHistory;
use App\Models\SocialMedia;


class LayoutController extends Controller
{
    public function index(){

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        if($instructor){
            $payment_methods = PaymentMethod::where('instructor_id',$instructor->id)->get(); 
            $courses = Course::where('instructor_id',$instructor->id);
            $total_course = $courses->count();
            $total_student = $courses->sum('enroll_count');
            $total_sale = PaymentHistory::where('instructor_id',$instructor->id)->sum('amount');
            return view('instructor.dashboard',[
                'page_title'=>'Dashboard',
                'payment_methods'=>$payment_methods,
                'instructor'=>$instructor,
                'total_course'=>$total_course,
                'total_student'=>$total_student,
                'total_sale'=>$total_sale,
            ]);
        }else{
            return view('pages.teach-on',[
                'page_title'=>'Teach On',
            ]);
        }
    }

    public function profileEdit(){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $social_media = SocialMedia::get();
    
        return view('instructor.instructor-profile-edit',[
            'page_title'=>"Profile Edit",
            'instructor'=>$instructor,
            'social_media'=>$social_media,
        ]);
    }

    public function error(){
        return view('instructor.error',[
            'page_title'=>"Error",
        ]);
    }
}
