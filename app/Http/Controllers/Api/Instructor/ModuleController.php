<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;

use Illuminate\Http\Request;

use App\Models\Module;
use App\Models\Course;

class ModuleController extends Controller
{
     public function index()
    {
       
    }

    public function store(Request $request)
    {
        $user = $request->user();
        
        $validatedData = $request->validate([
            'title'=>'required',
            'course_id'=>'required|numeric',
        ]);

      
        $course_id = $request->course_id;
        $Module = new Module();
        $Module->course_id = $request->course_id;
        $Module->title = $request->title;
        $Module->save();

        $course = Course::find($course_id);
        NotificationController::storeGroupNotification([
            'notification_type_id'=>28, // add new module
            'user_id'=>$user->id, // (active person)
            'passive_users'=>$course->users, // (passive people)
            'body'=>$course->title,
            'passive_user_type'=>3,
            'payload'=>[
                'module_id'=>$Module->id,
                'course_id'=>$course->id,
            ]
        ]);

        return $Module;
    }

    public function show(Post $post)
    {
         
    }

    public function update(Request $request, Post $post)
    {
        
    }

    public function destroy(Post $post)
    {
       
    }
}
