<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DraftCourse;

class DraftCourseController extends Controller
{
    public function create(Request $req){
        return $req->user();
    }
}
