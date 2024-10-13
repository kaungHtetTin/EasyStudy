<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
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
                return view('instructor.course-announcement',[
                    'page_title'=>'Announcements',
                    'course'=>$course,

                ]);
            }else{
                return redirect(route('instructor.error'));
            }
        }else{
            return redirect(route('instructor.error'));
        }
    }

    public function store(Request $req){
        $req->validate([
            'course_id'=>'required|numeric',
        ]);

        $user = $req->user();

        $course_id = $req->course_id;

        $content_exist = false;
        if(isset($req->body)){
            $content_exist = true;
            $body = $req->body;
        }else{
            $body = "";
        }

        if($req->hasFile('attach_photo')){
            $content_exist = true;
            $image = $req->file('attach_photo');
            $image_path = $image->store('images/announcements', 'public');
        }else{
            $image_path = "";
        }


        if($req->hasFile('attach_resource')){
            $content_exist = true;
            $resource = $req->file('attach_resource');
            $resource_path = $resource->store('resources','public');
        }else{
            $resource_path = "";
        }

        
        if(!$content_exist){
            return back()->with('input_error','Please add an announcement message or an attached photo');
        }

        $announcement = new Announcement();
        $announcement->course_id = $course_id;
        $announcement->body = $body;
        $announcement->image_url = $image_path;
        $announcement->resource_url = $resource_path;
        $announcement->save();

        $course = Course::find($course_id);
        NotificationController::storeGroupNotification([
            'notification_type_id'=>27, // post a announcement
            'user_id'=>$user->id, // (active person)
            'passive_users'=>$course->users, // (passive people)
            'body'=>$course->title,
            'passive_user_type'=>3,
            'payload'=>[
                'announcement_id'=>$announcement->id,
                'course_id'=>$course->id,
            ]
        ]);

        return back()->with('msg','New message was successfully announced');
    }
}
