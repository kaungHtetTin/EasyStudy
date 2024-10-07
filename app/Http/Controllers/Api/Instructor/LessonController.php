<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Module;
use App\Models\Instructor;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function store(Request $req){

        $user = $req->user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        $req->validate([
            'module_id'=>'required|numeric',
            'lesson_type_id'=>'required|numeric',
            'title'=>'required',
            'description'=>'required',
            'downloadable'=>'required',
            'free_preview'=>'required',
        ]);

        $module_id = $req->module_id;

        $module = Module::find($module_id);
        if($module==null){
            return response()->json(['status'=>'fail','message'=>'Bad request'],400);
        }

        $course = Course::find($module->course_id);
        if($course==null){
            return response()->json(['status'=>'fail','message'=>'Bad request'],400);
        }

        if($course->instructor_id!= $instructor->id){
            return response()->json(['status'=>'fail','message'=>'Forbidden'],403);
        }

        $lesson = new Lesson();
        $lesson->course_id = $course->id;
        $lesson->module_id = $module_id;
        $lesson->lesson_type_id = $req->lesson_type_id;
        $lesson->title = $req->title;
        $lesson->description = $req->description;
        $lesson->downloadable = $req->downloadable=='true' ? 1 : 0;
        $lesson->free_preview = $req->free_preview== 'true' ? 1 : 0;

        // add thumbnail if the lessos is video

        $existContent = false;
        if(isset($req->attachment)){
            $existContent = true;
            $req->validate([
                'attachment'=>'required|file|mimes:jpeg,png,jpg,pdf,zip',
            ]);

            if ($req->hasFile('attachment')) {
                $attachment = $req->file('attachment');
                $path = $attachment->store('resources', 'public');
                $lesson->link = $path;
              
            }
        }

        if(isset($req->download_url)){
            $existContent = true;
            $lesson->download_url = $req->download_url;
        }

        if(!$existContent){
            return response()->json(['status'=>'fail','message'=>'Bad request'],400);
        }

        // defind video size
        // defind video duration

        $lesson->save();

        return response()->json($lesson, 200);
    }


}
