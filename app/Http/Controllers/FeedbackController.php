<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index(){

    }

    public function create(){
        return view('student.feedback-create',[
            'page_title'=>'Feedback',
        ]);
    }

    public function show($id){
        return $id;
    }

    public function store(Request $req){
        $user = Auth::user();
        $content_exist = false;
        $description = "";
        if(isset($req->description)){
            $description = $req->description;
            $content_exist = true;
        } 

        $screenshot_url = "";
        if($req->hasFile('screenshot_image')){
            $content_exist = true;
            $image = $req->file('screenshot_image');
            $screenshot_url = $image->store('images/feedback', 'public');
        }

        if($content_exist){
            $feedback = new Feedback();
            $feedback->user_id = $user->id;
            $feedback->description = $description;
            $feedback->screenshot_url = $screenshot_url;
            $feedback->save();

            NotificationController::store([
            'notification_type_id'=>8,
            'user_id'=>$user->id,
            'passive_user_id'=>2, // super admin
            'passive_user_type'=>1, // admin
            'body'=>"",
            'payload'=>[]
        ]);

            return back()->with('msg','Thanks for sending a valuable feedback to us.');
        }else{  
            return back()->with('error','Please enter the description or add screenshot');
        }
    }
}
