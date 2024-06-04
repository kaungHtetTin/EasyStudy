<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\Category;

class InstructorController extends Controller
{
    //

    public function index(){
        $instructors = Instructor::all();
        $categories = Category::all();
        return view('instructors',[
            'page_title'=>'Instructors',
            'instructors'=>$instructors,
            'categories'=>$categories,
        ]);
    }

    public function detail($id){
        $instructor = Instructor::find($id);
        $categories = Category::all();
        return view('instructor_profile',[
            'page_title'=>'Detail',
            'instructor'=>$instructor,
            'categories'=>$categories,
        ]);
    }
}
