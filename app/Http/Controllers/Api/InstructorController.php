<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Instructor;

class InstructorController extends Controller
{
    public function index(Request $req){

        $instructors = Instructor::with('user:id,name,email,phone,address')
        ->with('categories')->paginate(12);
        
        return $instructors;

    }
}
