<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;
use App\Models\SavedCourse;
use App\Models\Review;
use App\Models\PaymentHistory;
use App\Models\Reaction;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $req){


        // $categoryIds=$req->category_ids;
        // $courses = Course::whereIn('category_id', $categoryIds)->get();
        // return $courses;

        $category_id = $req->category_id;
        $sub_categories = SubCategory::where('category_id',$category_id)->get();

        $levels = Level::all();
        
        if(isset($req->sub_category_id)){
            $sub_category_id = $req->sub_category_id;
        }else{
            $sub_category_id = $sub_categories[0]->id;
        }

        $topics = Topic::where('sub_category_id',$sub_category_id)->get();

        $courses = Course::where('sub_category_id',$sub_category_id)->get();

        return view('courses',[
            'page_title'=>'Courses',
            'sub_categories'=>$sub_categories,
            'sub_category_id'=>$sub_category_id,
            'topics'=>$topics,
            'courses'=>$courses,
            'levels'=>$levels,
        ]);

        if(isset($req->category_id)){
            $courses = Course::where('category_id',$req->category_id)->get();
            return $courses;
        }

        if(isset($req->sub_category_id)){
            $courses = Course::where('category_id',$req->sub_category_id)->get();
            return $courses;
        }

        if(isset($req->topic_id)){
            $courses = Course::where('category_id',$req->topic_id)->get();
            return $courses;
        }

        $courses = Course::all();
        return $courses;
    }

    public function detail($id){

        $course = Course::find($id);
        $user = Auth::user();
        $myReview=false;
        $access=false;
        $reaction = false;
        $subscribed = false;
        if (Auth::check()) {
            $myReview = Review::where('user_id',$user->id)->where('course_id',$course->id)->first();
            
            if($myReview==null){
                $myReview=false;
            }

            $access = SavedCourse::where('user_id',$user->id)->where('course_id',$course->id)->first();
            if($access==null){
                $access=false;
            }

            $reaction = Reaction::where('user_id',$user->id)->where('content_id',$id)->first();
            if($reaction==null){
                $reaction = false;
            }

            $subscribed = Subscriber::where('user_id',$user->id)->where('instructor_id',$course->instructor_id)->first();
            if($subscribed==null){
                $subscribed=false;
            }

        }

        $course->visit = ($course->visit)+1;
        $course->save();


        return view('course_detail',[
            'page_title'=>'Detail',
            'course'=>$course,
            'myReview'=>$myReview,
            'access'=>$access,
            'reaction'=>$reaction,
        ]);
    }


    public function myCourse(){
        $user = Auth::user();
        $myCourses = SavedCourse::where('user_id',$user->id)->get();

        return view('my_courses',[
            'page_title'=>'My Courses',
            'myCourses'=>$myCourses,
        ]);
    }

    public function update(){
        $course = Course::find(1);
        $course->description = request()->requirements;
        $course->save();

        return 'success';
    }

    public function checkOut(Request $req,$id){
        $user = Auth::user();
        $course = Course::find($id);

        $validatedData = $req->validate([
            'screenshot' => 'required|image',
            'payment'=>'required|integer',
        ]);

        $image = $req->file('screenshot');
        $path = $image->store('images/payments', 'public');
        
        $payment = new PaymentHistory();
        $payment->user_id = $user->id;
        $payment->course_id = $id;
        $payment->payment_method_id = $req->payment;
        $payment->amount = $course->fee;
        $payment->billed = 0;
        $payment->save();

        $saved_course = new SavedCourse();
        $saved_course->user_id = $user->id;
        $saved_course->course_id = $id;
        $saved_course->verified = 0;
        $saved_course->disable = 0;
        $saved_course->save();

        return redirect()->back()->with('check_out_status','Succesfully requested');
    }

}
