<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Category;
use App\Models\Subscriber;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    //

    public function index(){
        $social_media = SocialMedia::all();
        return view('student.instructors',[
            'page_title'=>'Instructors',
            'social_media'=>$social_media,
        ]);
    }

    public function detail($id){
        $instructor = Instructor::find($id);
        $subscribed = false;

        if (Auth::check()) {
            $subscribed = Subscriber::where('user_id',Auth::user()->id)->where('instructor_id',$id)->first();
            if($subscribed==null){
                $subscribed=false;
            }
        }

   
        return view('student.instructor_profile',[
            'page_title'=>'Detail',
            'instructor'=>$instructor,
            'subscribed'=>$subscribed,
        ]);
    }

    public function subscribe(Request $req,$id){
       
        $user = Auth::user();
        $user_id = $user->id;
        
        $instructor = Instructor::find($id);

        $subscribed = Subscriber::where('user_id',$user_id)->where('instructor_id',$id)->first();
        if($subscribed){
            // unsubscribe
            $subscribed->delete();
            $instructor->subscriber = max(0,$instructor->subscriber-1);
        }else{
            // subscribe
            $subscriber = new Subscriber();
            $subscriber->user_id = $user_id;
            $subscriber->instructor_id = $id;
            $subscriber->save();

            $instructor->subscriber = $instructor->subscriber+1;
        }

        $instructor->save();

        return redirect()->back();
        
    }

}
