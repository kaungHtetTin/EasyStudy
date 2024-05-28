<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
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
