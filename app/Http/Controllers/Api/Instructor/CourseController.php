<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\User;
use App\Models\SavedCourse;

use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
       
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        $validatedData = $request->validate([
            'title'=>'required',
            'description'=>'required',
            'language_id'=>'required',
            'level_id'=>'required|numeric',
            'category_id'=>'required|numeric',
            'sub_category_id'=>'required|numeric',
            'certificate'=>'required',
            'topic_id'=>'required',
            'thumbnail_file'=>'required|mimes:jpeg,png,jpg,gif,JPG,PNG|max:10485760',
            'fee'=>'required|numeric',
            'discount'=>'required|numeric',
        ]);

        $course = new Course();

        $course->instructor_id = $instructor->id;
        $course->level_id = $request->level_id;
        $course->category_id = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->topic_id = $request->topic_id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->language_id = $request->language_id;
        $course->certificate = $request->certificate=='true'?1:0;
        $course->fee = $request->fee;
        $course->discount = $request->discount;
       
        if ($request->hasFile('thumbnail_file')) {
            $image = $request->file('thumbnail_file');
            $path = $image->store('images/courses', 'public');
            $course->cover_url = $path;
            $course->save();
            return response()->json($course, 201);
        }
        
        return response()->json("error");
    }

    public function show($id)
    {
        return $id;
    }

    public function update(Request $request, $id)
    {
    
        $user = $request->user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $course = Course::find($id);
        if($course==null){
            return response()->json(['status'=>'fail','message'=>'Bad request'],400);
        }

        if($course->instructor_id!= $instructor->id){
            return response()->json(['status'=>'fail','message'=>'Forbidden'],403);
        }

        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'language_id'=>'required',
            'level_id'=>'required|numeric',
            'category_id'=>'required|numeric',
            'sub_category_id'=>'required|numeric',
            'certificate'=>'required',
            'topic_id'=>'required',
            'fee'=>'required|numeric',
            'discount'=>'required|numeric',
        ]);

        $course->level_id = $request->level_id;
        $course->category_id = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->topic_id = $request->topic_id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->language_id = $request->language_id;
        $course->certificate = $request->certificate=='true'?1:0;
        $course->fee = $request->fee;
        $course->discount = $request->discount;
        $course->save();
        return response()->json($course, 200);

    }

    public function changeCoverImage(Request $request, $id){
 
        $request->validate([
            'thumbnail_file' => 'required|file|mimes:jpeg,png,jpg',
        ]);

        $user = $request->user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $course = Course::find($id);
        if($course==null){
            return response()->json(['status'=>'fail','message'=>'Bad request'],400);
        }
        if($course->instructor_id!= $instructor->id){
            return response()->json(['status'=>'fail','message'=>'Forbidden'],403);
        }

        $old_path =  $course->cover_url;

        if ($request->hasFile('thumbnail_file')) {
            $image = $request->file('thumbnail_file');
            $path = $image->store('images/courses', 'public');
            $course->cover_url = $path;
            $course->save();
            
            if ($old_path) {
                Storage::disk('public')->delete($old_path); // Delete old image
            }
            return response()->json($course, 201);
        }

        return response()->json(['status' => 'fail', 'message' => 'No image file provided'], 400);

    }

    public function students(Request $request, $id){

    
        $user = $request->user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $course = Course::find($id);

        if($course==null){
            return response()->json(['status'=>'fail','message'=>'Bad request'],400);
        }
        if($course->instructor_id!= $instructor->id){
            return response()->json(['status'=>'fail','message'=>'Forbidden'],403);
        }

        $students = SavedCourse::with('user:id,name,email,fcm_token,image_url')->where('course_id',$course->id)
        ->orderBy('id','DESC')->paginate(10);

        return response()->json($students, 201);
    }

    public function destroy(Post $post)
    {
       
    }
    
}
