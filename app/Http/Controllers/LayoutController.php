<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Category;

class LayoutController extends Controller
{
    public function index(){

        $newestCourses = Course::limit(10)->orderBy('id','desc')->get();
        $featureCourses = Course::limit(10)->orderBy('id','asc')->get();
        $popularInstructors = Instructor::limit(10)->orderBy('student_enroll','desc')->get();
        $categories = Category::all();

        return view('index',[
            'page_title'=>'Home',
            'newestCourses'=>$newestCourses,
            'featureCourses'=>$featureCourses,
            'popularInstructors'=>$popularInstructors,
            'categories'=>$categories,
        ]);
    }
}
