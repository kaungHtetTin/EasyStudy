<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Category;
use App\Models\Review;

class LayoutController extends Controller
{
    public function index(){

        $newestCourses = Course::limit(10)->orderBy('id','desc')->get();
        $featureCourses = Course::limit(10)->orderBy('id','asc')->get();
        $popularInstructors = Instructor::limit(10)->orderBy('student_enroll','desc')->get();
        $reviews = Review::limit(10)->get();
        
        return view('index',[
            'page_title'=>'Home',
            'newestCourses'=>$newestCourses,
            'featureCourses'=>$featureCourses,
            'popularInstructors'=>$popularInstructors,
            'reviews'=>$reviews,
        ]);
    }

    public function teachOn(){
        return  view('teach-on',[
            'page_title'=>'Teach On',
        ]);
    }
}
