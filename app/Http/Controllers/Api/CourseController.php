<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Reaction;
use App\Models\Review;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Announcement;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // make some logic for fetching course
        $courses = Course::with('instructor.user')
        ->with('category:id,title')
        ->with('sub_category:id,title')
        ->with('topic:id,title')
        ->where('disable',0)->paginate(10);
       
        return $courses;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    public function filterCourse(){

    }

    public function share($id){
        $course = Course::findOrFail($id);
        $course->share_count = ($course->share_count)+1;
        $course->save();

        return "success";
    }

    public function playPreView($id){
        $course = Course::findOrFail($id);
        $course->preview_count = ($course->preview_count)+1;
        $course->save();

        return "success";
    }

    public function react(Request $req, $id) {
        $content_type = 1;
        $this->validate($req, [
            'react' => 'required|integer|in:1,2',
            'user_id' => 'required|integer'
        ]);
        
        $react = $req->react;
        $user_id = $req->user_id;

        $course = Course::find($id);
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        // Check if the user has already reacted with the same reaction
        $existingReaction = Reaction::where('user_id', $user_id)
            ->where('content_id', $id)
            ->where('content_type', $content_type)
            ->where('react', $react)
            ->first();

        if ($existingReaction) {
            // Remove the existing reaction
            if ($existingReaction->react == 1) {
                $course->like_count = max(0, $course->like_count - 1);
            } elseif ($existingReaction->react == 2) {
                $course->dislike_count = max(0, $course->dislike_count - 1);
            }
            $existingReaction->delete();
        } else {
            // Remove any other existing reaction by the user on this content
            $previousReaction = Reaction::where('user_id', $user_id)
                ->where('content_id', $id)
                ->where('content_type', $content_type)
                ->first();

            if ($previousReaction) {
                if ($previousReaction->react == 1) {
                    $course->like_count = max(0, $course->like_count - 1);
                } elseif ($previousReaction->react == 2) {
                    $course->dislike_count = max(0, $course->dislike_count - 1);
                }
                $previousReaction->delete();
            }

            // Create a new reaction
            $newReaction = new Reaction();
            $newReaction->user_id = $user_id;
            $newReaction->content_id = $id;
            $newReaction->content_type = $content_type;
            $newReaction->react = $react;
            $newReaction->save();

            if ($react == 1) {
                $course->like_count += 1;
            } elseif ($react == 2) {
                $course->dislike_count += 1;
            }
        }

        $course->save();

        return response()->json(['success' => true]);
    }


    public function reviews($id){

        $reviews = Review::with('user:id,name,email,fcm_token,image_url')->where('course_id',$id)->paginate(10);
        return $reviews;
    }

    public function questions($id){
        $questions = Question::with('user:id,name,email,fcm_token,image_url')
        ->where('course_id',$id)
        ->orderBy('id','DESC')
        ->paginate(10);

        return $questions;
    }

    public function answers($id, $qid){
        $answers = Answer::with('user:id,name,email,fcm_token,image_url')->where('question_id',$qid)->paginate(10);
        $questions = Question::with('user:id,name,email,fcm_token,image_url')->find($qid);
        
        $res['answer']=$answers;
        $res['question']=$questions;

        return response()->json($res);
    }

    public function announcements($id){
        $announcements = Announcement::where('course_id',$id)->orderBy('id','DESC')->paginate(10);
        return $announcements;
    }

    public function lessons(Request $req, $id){
        $lessons = Lesson::with('course')->with('module')->where('course_id',$id)->get();
        $modules = Module::where('course_id',$id)->get();
        $course = Course::find($id);
        
        $res['modules'] = $modules;
        $res['lessons'] = $lessons;
        $res['course'] = $course;

        return $res;
    }

    public function search(Request $req){
        $req->validate([
            'q'=>'required',
        ]);

        $search_str = $req->q;

         $courses = Course::selectRaw(
            'courses.*,
            categories.title as category_title,
            sub_categories.title as sub_category_title,
            topics.title as topic_title'
            )
        ->with('instructor.user')
        ->with('category:id,title')
        ->with('sub_category:id,title')
        ->with('topic:id,title')
        ->join('categories','categories.id','=','courses.category_id')
        ->join('sub_categories','sub_categories.id','=','courses.sub_category_id')
        ->join('topics','topics.id','=','courses.topic_id')
        ->orWhere('courses.title','like','%'.$search_str.'%')
        ->orWhere('categories.title','like','%'.$search_str.'%')
        ->orWhere('sub_categories.title','like','%'.$search_str.'%')
        ->orWhere('topics.title','like','%'.$search_str.'%')
        ->where('disable',0)
        ->paginate(10);

        return $courses;
    }

    public function searchQuestion(Request $req,$id){
        $req->validate([
            'q'=>'required',
        ]);

        $search_str = $req->q;

        $questions = Question::with('user:id,name,email,fcm_token,image_url')
        ->orWhere('title','like','%'.$search_str.'%')
        ->orWhere('body','like','%'.$search_str.'%')
        ->where('course_id',$id)
        ->orderBy('id','DESC')
        ->paginate(10);

        return $questions;
    }


}
