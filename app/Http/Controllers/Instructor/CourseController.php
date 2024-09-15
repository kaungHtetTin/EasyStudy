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

use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courses = Course::all();
        return $courses;
    }

    public function create(){
        $topics = Topic::all();
        $sub_categories = SubCategory::all();
        $levels = Level::all();
        return view('instructor.course-create',[
            'topics'=>$topics,
            'sub_categories'=>$sub_categories,
            'levels'=>$levels
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
        //
    }

}
