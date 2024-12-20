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
use App\Models\QuestionType;
use App\Models\Cart;
use App\Models\Instructor;
use App\Models\Notification;
use App\Models\Visit;

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

        $courses = Course::with('instructor.user')
        ->with('category:id,title')
        ->with('sub_category:id,title')
        ->with('topic:id,title')
        ->where('sub_category_id',$sub_category_id)->where('disable',0)->get();

        return view('student.courses',[
            'page_title'=>'Courses',
            'sub_categories'=>$sub_categories,
            'sub_category_id'=>$sub_category_id,
            'topics'=>$topics,
            'courses'=>$courses,
            'levels'=>$levels,
        ]);
    }

    public function detail($id){

        $course = Course::find($id);

        if($course==null){
            return redirect()->route('error');
        }

        $user = Auth::user();
        $myReview=false;
       
        $reaction = false;
        $subscribed = false; // check subscribed to instructor
        if (Auth::check()) {

            $access = SavedCourse::where('user_id',$user->id)->where('course_id',$course->id)->first();
            if($access || $course->fee == 0){
                return redirect()->route('course.learn',['id'=>$id]);
            }

            $myReview = Review::where('user_id',$user->id)->where('course_id',$course->id)->first();
            
            if($myReview==null){
                $myReview=false;
            }


            $reaction = Reaction::where('user_id',$user->id)->where('content_id',$id)->first();
            if($reaction==null){
                $reaction = false;
            }

            $subscribed = Subscriber::where('user_id',$user->id)->where('instructor_id',$course->instructor_id)->first();
            if($subscribed==null){
                $subscribed=false;
            }

            if($user->id != $course->instructor->user->id){
                $visit = new Visit();
                $visit->user_id = $user->id;
                $visit->course_id = $course->id;
                $visit->save();
            }
        }

        $course->visit = ($course->visit)+1;
        $course->save();

        $review_stars = Review::selectRaw("count(*) star_count, star")
        ->groupBy('star')
        ->where('course_id',$id)
        ->get();

        return view('student.course_detail',[
            'page_title'=>'Detail',
            'course'=>$course,
            'myReview'=>$myReview,
            'reaction'=>$reaction,
            'subscribed'=>$subscribed,
            'review_stars'=> $review_stars,
        ]);
    }


    public function myCourse(){
        $user = Auth::user();
        $myCourses = SavedCourse::where('user_id',$user->id)->get();

        return view('student.my_courses',[
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
        $payment->instructor_id = $course->instructor_id;
        $payment->course_id = $id;
        $payment->payment_method_id = $req->payment;
        $payment->amount = $course->fee;
        $payment->screenshot_url = $path;
        $payment->billed = 0;
        $payment->save();

        $saved_course = new SavedCourse();
        $saved_course->user_id = $user->id;
        $saved_course->course_id = $id;
        $saved_course->verified = 0;
        $saved_course->disable = 0;
        $saved_course->save();

        $course->enroll_count = $course->enroll_count+1;
        $course->save();

        $instructor = Instructor::find($course->instructor_id);
        $instructor->student_enroll = $instructor->student_enroll + 1;
        $instructor->save();

        NotificationController::store([
            'notification_type_id'=>21,
            'user_id'=>$user->id,
            'passive_user_id'=>$course->instructor->user->id,
            'passive_user_type'=>2,
            'body'=>$course->title,
            'payload'=>[
                'course_id'=>$course->id,
            ]
        ]);

        $cart = Cart::where('user_id',$user->id)->where('course_id',$id)->first();
        if($cart) $cart->delete();

        return redirect()->back()->with('check_out_status','Succesfully requested');
    }

    public function learn(Request $req,$id){
        $course = Course::find($id);
        $user = Auth::user();
        $myReview=false;

        if(isset($req->question_id)) $question_id = $req->question_id; // for notification click
        else $question_id = 0; 

        if(isset($req->announcement_id)) $announcement_id = $req->announcement_id; // for notification click
        else $announcement_id = 0; 
     
        $access = SavedCourse::where('user_id',$user->id)->where('course_id',$course->id)->first();
        if(!$access){
            if($course->fee > 0)  return redirect()->route('course_detail',['id'=>$id]);
        }

        if (Auth::check()) {
            $myReview = Review::where('user_id',$user->id)->where('course_id',$course->id)->first();
            if($myReview==null){
                $myReview=false;
            }
        }
        
        $question_types = QuestionType::where('course_id',$id)->get();
        if(count($question_types)==0){
            $question_types = false;
        }

        $subscribed = Subscriber::where('user_id',$user->id)->where('instructor_id',$course->instructor_id)->first();
        if($subscribed==null){
            $subscribed=false;
        }

        $reaction = Reaction::where('user_id',$user->id)->where('content_id',$id)->first();
        if($reaction==null){
            $reaction = false;
        }

        $review_stars = Review::selectRaw("count(*) star_count, star")
        ->groupBy('star')
        ->where('course_id',$id)
        ->get();

        return view('student.course_learn',[
            'page_title'=>'Learning',
            'course'=>$course,
            'myReview'=>$myReview,
            'access'=>$access,
            'question_types'=>$question_types,
            'subscribed'=>$subscribed,
            'reaction'=>$reaction,
            'question_id'=>$question_id,
            'announcement_id'=>$announcement_id,
            'review_stars'=> $review_stars,
        ]);
    }

}
