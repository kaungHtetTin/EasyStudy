<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function index(){
        return view('instructor.dashboard');
    }

    public function courseCreate(){
        return view('instructor.course-create');
    }
}
