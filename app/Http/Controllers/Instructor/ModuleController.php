<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index(Request $req){
        $course_id = $req->course_id;
        $course = Course::find($course_id);
        return view('instructor.modules',[
            'page_title'=>$course->title,
            'course'=>$course,

        ]);
    }

    public function store(Request $req){
        return redirect(route('instructor.modules.lists')."?course_id=$course_id");
        $validated = $req->validate([
            'course_id'=>'required',
            'title' => 'required',
        ]);
        $course_id = $req->course_id;
        $Module = new Module();
        $Module->course_id = $req->course_id;
        $Module->title = $req->title;
        $Module->save();

        return redirect(route('instructor.modules.lists')."?course_id=$course_id");
    }

    public function update(Request $req, $id){
        $module = Module::find($id);
        $req->validate([
            'title'=>'required',
        ]);

        $module->title = $req->title;
        $module->save();
        return back()->with('msg',"Section title has been updated successfully.");
    }

    public function destroy($id){
        Module::find($id)->delete();
        return back()->with('msg','Section has been deleted successfully.');
    }
}
