<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use App\Models\Instructor;
use App\Models\ReportType;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(){
        return view('student.reports',[
            'page_title'=>'Report History',
        ]);
    }

    public function create(Request $req){
        $course = $review = $reported_user = $instructor = false;

        $req->validate([
            'id'=>'required',
            'type'=>'required',
        ]);

        $id = $req->id;
        $type = $req->type;

        if($type == 1){
            $course = Course::find($id);
            if(!$course)  return redirect()->route('error');
        }elseif($type == 2){
            $review = Review::find($id);
            if(!$review)  return redirect()->route('error');
        }elseif($type == 3){
            $reported_user = User::find($id);
            if(!$reported_user)  return redirect()->route('error');
        }elseif($type == 4){
            $instructor = Instructor::find($id);
            if(!$instructor)  return redirect()->route('error');
        }else{
            return redirect()->route('error');
        }

        $report_types = ReportType::all();

        return view('student.report-create',[
            'page_title'=>'Report Now',
            'content_id' => $id,
            'content_type_id' => $type,
            'course' => $course,
            'review'=> $review,
            'reported_user' => $reported_user,
            'instructor' => $instructor,
            'report_types' => $report_types,
        ]);
    }

    public function store(Request $req){

        $req->validate([
            'report_type_id'=>'required',
            'content_type_id'=>'required',
            'content_id'=>'required',
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $body = "";
        if($req->description !== null) $body = $req->description;

        $report = new Report();
        $report->user_id = $user_id;
        $report->report_type_id = $req->report_type_id;
        $report->content_type_id = $req->content_type_id;
        $report->content_id = $req->content_id;
        $report->body = $body;
        $report->action_taken = 0;

        $report->save();

        return back()->with('msg','Successufully reported');
    }

    public function show($id){
        return $id;
    }
}
