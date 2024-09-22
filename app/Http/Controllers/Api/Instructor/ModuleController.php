<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Module;

class ModuleController extends Controller
{
     public function index()
    {
       
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'title'=>'required',
            'course_id'=>'required|numeric',
        ]);

      
        $course_id = $request->course_id;
        $Module = new Module();
        $Module->course_id = $request->course_id;
        $Module->title = $request->title;
        $Module->save();

        return $Module;
    }

    public function show(Post $post)
    {
         
    }

    public function update(Request $request, Post $post)
    {
        
    }

    public function destroy(Post $post)
    {
       
    }
}
