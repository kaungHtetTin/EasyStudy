<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;

class InstructorController extends Controller
{
    //

    public function index(){
        $instructors = Instructor::all();
        return view('instructors',[
            'page_title'=>'Instructors',
            'instructors'=>$instructors,
        ]);
    }

    public function detail($id){
        $instructor = Instructor::find($id);
        return view('instructor_profile',[
            'page_title'=>'Detail',
            'instructor'=>$instructor,
        ]);
    }
}
