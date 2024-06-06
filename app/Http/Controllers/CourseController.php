<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;

class CourseController extends Controller
{
    public function index(Request $req){


        // $categoryIds=$req->category_ids;
        // $courses = Course::whereIn('category_id', $categoryIds)->get();
        // return $courses;

        $category_id = $req->category_id;
        $categories = Category::all();
        $sub_categories = SubCategory::where('category_id',$category_id)->get();

        $levels = Level::all();
        
        if(isset($req->sub_category_id)){
            $sub_category_id = $req->sub_category_id;
        }else{
            $sub_category_id = $sub_categories[0]->id;
        }

        $topics = Topic::where('sub_category_id',$sub_category_id)->get();

        $courses = Course::where('sub_category_id',$sub_category_id)->get();
        
        
      
        return view('courses',[
            'page_title'=>'Courses',
            'categories'=>$categories,
            'sub_categories'=>$sub_categories,
            'sub_category_id'=>$sub_category_id,
            'topics'=>$topics,
            'courses'=>$courses,
            'levels'=>$levels,
        ]);

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