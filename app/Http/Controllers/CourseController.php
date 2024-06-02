<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    public function index(Request $req){
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
        
        $categories = Category::all();
        
     
        return view('course_detail',[
            'page_title'=>'Detail',
            'course'=>$course,
            'categories'=>$categories,
        ]);
    }
}
