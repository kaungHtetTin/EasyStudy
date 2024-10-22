<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Visit;
use App\Models\Instructor;



class VisitController extends Controller
{
    public function index(){

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $year = date('Y');
        $month = date('m');

        $visits = Visit::selectRaw("visits.*, courses.title as course_title")
        ->with('user:id,name,image_url')
        ->join('courses','courses.id','=','course_id')
        ->where('courses.instructor_id',$instructor->id)
        ->where(DB::raw("YEAR(visits.created_at)"),$year)
        ->where(DB::raw("MONTH(visits.created_at)"),$month)
        ->orderBy('id','desc')
        ->get();

        $registers = [];
        $filtered_visits = [];
        foreach($visits as $visit){
            $register_id = $visit->user_id.$visit->course_id;
            if(count($registers)>0){
                $exist = false;
                foreach($registers as $register){
                    if($register_id == $register) $exist = true;
                }
                if(!$exist){
                    $registers [] = $register_id;
                    $filtered_visits[] =$visit;
                }
            }else{
                $registers [] = $register_id;
                $filtered_visits[] =$visit;
            }
        }

        return view('instructor.visits',[
            'page_title'=>'Recent Visits',
            'visits'=>$filtered_visits,
        ]);
    }

    public function show($id){
        $visit = Visit::find($id);
        $course = $visit->course;
        if(Gate::denies('my-course',$course))  redirect(route('instructor.error'));

        $count = Visit::where('user_id',$visit->user_id)
        ->where('course_id',$visit->course_id)
        ->count();

        $year = date('Y');
        $month = date('m');

        $visit_times = DB::table('visits')
                        ->selectRaw(DB::raw("count(*) as visit_count, Day(created_at) as day"))
                        ->where(DB::raw("YEAR(created_at)"),$year)
                        ->where(DB::raw("MONTH(created_at)"),$month)
                        ->where('course_id',$course->id)
                        ->where('user_id',$visit->user_id)
                        ->groupBy("day")
                        ->get();
   

        return view('instructor.visit-detail',[
            'page_title'=>'Visit Detail',
            'visit'=>$visit,
            'count'=>$count,
            'visit_times'=>$visit_times,
        ]);
    }
}
