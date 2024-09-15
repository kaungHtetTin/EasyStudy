<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;

class CourseController extends Controller
{
    public function index()
    {
       
    }

    public function store(Request $request)
    {
        
        $user = $request->user();
        $instructor = Instructor::find($user->id);

        $validatedData = $request->validate([
            'title'=>'required',
            'description'=>'required',
            'language'=>'required',
            'level_id'=>'required|numeric',
            'category_id'=>'required|numeric',
            'sub_category_id'=>'required|numeric',
            'certificate'=>'required',
            'topic_id'=>'required',
            'thumbnail_file'=>'required|mimes:jpeg,png,jpg,gif,JPG,PNG|max:10485760',
        ]);

        $course = new Course();

        $course->instructor_id = $instructor->id;
        $course->level_id = $request->level_id;
        $course->category_id = $request->category_id;
        $course->sub_category_id = $request->sub_category_id;
        $course->topic_id = $request->topic_id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->language = $request->language;
        $course->certificate = $request->certificate=='true'?1:0;
       
        if ($request->hasFile('thumbnail_file')) {
            $image = $request->file('thumbnail_file');
            $path = $image->store('images/courses', 'public');
            $course->cover_url = $path;
            $course->save();
            return response()->json($course, 201);
        }
        
        return response()->json("error");
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
