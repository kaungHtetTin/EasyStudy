<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Reaction;
use App\Models\Review;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Instructor;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;
use App\Models\Language;

use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $courses = Course::with('category')->where('instructor_id',$instructor->id)->get();
    
        return view('instructor.courses',[
            'courses'=>$courses,
            'page_title'=>'Courses'
        ]);
    }

    public function create(){
        $topics = Topic::all();
        $sub_categories = SubCategory::all();
        $categories = Category::all();
        $levels = Level::all();
        $languages = Language::all();
        return view('instructor.course-create',[
            'topics'=>$topics,
            'sub_categories'=>$sub_categories,
            'categories'=>$categories,
            'levels'=>$levels,
            'languages'=>$languages,
            'page_title'=>'Create Course',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        $validatedData = $request->validate([
            'title'=>'required',
            'short'=>'required',
            'description'=>'required',
            'language'=>'required',
            'level_id'=>'required|numeric',
            'category_id'=>'required|numeric',
            'sub_category_id'=>'required|numeric',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id){

        $course = Course::find($id);
        if(!$course) return redirect(route('instructor.error'));

        $categories = Category::all();
        $topics = Topic::all();
        $sub_categories = SubCategory::all();
        $levels = Level::all();
        $languages = Language::all();
        $user = Auth::user();
        $instructor = $course->instructor;

        if($user->id != $instructor->user->id){
            return redirect(route('instructor.error'));
        }

        return view('instructor.course-edit',[
            'user'=>$user,
            'topics'=>$topics,
            'sub_categories'=>$sub_categories,
            'categories'=>$categories,
            'levels'=>$levels,
            'languages'=>$languages,
            'course'=>$course,
            'page_title'=>'Edit Course',
        ]);


    }


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $id;   
    }

    public function overview($id){
        $user = Auth::user();
        $course = Course::find($id);
 
        if($course){
            if($course->instructor->user->id ==$user->id ){
                return view('instructor.course-overview',[
                    'page_title'=>'Course Overview',
                    'course'=>$course,

                ]);
            }else{
                return redirect(route('instructor.error'));
            }
        }else{
            return redirect(route('instructor.error'));
        }
    }

    public function studentEnroll($id){
        $user = Auth::user();
        $course = Course::find($id);
 
        if($course){
            if($course->instructor->user->id ==$user->id ){
                return view('instructor.course-students',[
                    'page_title'=>'Students Enrolled',
                    'course'=>$course,

                ]);
            }else{
                return redirect(route('instructor.error'));
            }
        }else{
            return redirect(route('instructor.error'));
        }
    }

}
