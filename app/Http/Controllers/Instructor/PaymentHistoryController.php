<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\Instructor;
use App\Models\PaymentHistory;
use App\Models\SavedCourse;
use App\Models\Course;
 

class PaymentHistoryController extends Controller
{
    public function index(Request $req){

        if(isset($req->verified)) $verified = $req->verified;
        else $verified = 2;

        if(isset($req->year)) $year = $req->year;
        else $year = date('Y');

        if(isset($req->month)) $month = $req->month;
        else $month = date('m');

        $current_year =  date('Y');
        $cuurent_month = date('m');

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        if($verified==2){
            $payment_histories = PaymentHistory::where('instructor_id',$instructor->id)
            ->where('created_at','>=',"$year-$month-01")
            ->where('created_at','<=',"$year-$month-31")
            ->orderBy('verified')
            ->get();
        }else{
             $payment_histories = PaymentHistory::where('instructor_id',$instructor->id)
            ->where('verified',$verified)
            ->where('created_at','>=',"$year-$month-01")
            ->where('created_at','<=',"$year-$month-31")
            ->get();
        }
       
        $earning_today = PaymentHistory::where('instructor_id',$instructor->id)
        ->where('created_at','>=',date('Y-m-d'))
        ->sum('amount');

        $earning_request_month = PaymentHistory::where('instructor_id',$instructor->id)
        ->where('created_at','>=',"$year-$month-01")
        ->where('created_at','<=',"$year-$month-31")
        ->sum('amount');
     
        $earning_current_year = PaymentHistory::where('instructor_id',$instructor->id)
        ->where(DB::raw('YEAR(created_at)'),$year)
        ->sum('amount');

        $earning_all_time = PaymentHistory::where('instructor_id',$instructor->id)->sum('amount');

        $earning_current_month = PaymentHistory::where('instructor_id',$instructor->id)
        ->where('created_at','>=',"$current_year-$cuurent_month-01")
        ->where('created_at','<=',"$current_year-$cuurent_month-31")
        ->sum('amount');

        return view('instructor.statements',[
            'page_title'=>'Statements',
            'payment_histories'=>$payment_histories,
            'verified'=>$verified,
            'request'=>[
                'verified'=>$verified,
                'year'=>$year,
                'month'=>$month
            ],
            'earning_today'=>$earning_today,
            'earning_current_month'=>$earning_current_month,
            'earning_current_year'=>$earning_current_year,
            'earning_all_time'=>$earning_all_time,
            'earning_request_month'=>$earning_request_month,
        ]);
    }

    public function update(Request $req,$id){
        $req->validate([
            'verified'=>'required|numeric',
        ]);

        $payment_history = PaymentHistory::find($id);
        $user_id = $payment_history->user_id; // student
        $course_id = $payment_history->course_id;

        $course = Course::find($course_id);

        if(Gate::denies('my-course',$course)){
            return back()->with('error','Unauthorize');
        }

        $payment_history->verified = 1;
        $payment_history->save();

        $savedCourse = SavedCourse::where('user_id',$user_id)->where('course_id',$course_id)->first();
        $savedCourse->verified = 1;
        $savedCourse->save();

        NotificationController::store([
            'notification_type_id'=>22,
            'user_id'=>Auth::user()->id, // instructor (active person)
            'passive_user_id'=>$user_id, // student (passive person)
            'passive_user_type'=>3,
            'body'=>$course->title,
            'payload'=>[
                'course_id'=>$course_id,
                'payment_id'=>$id,
            ]
        ]);
        
        return back()->with('msg','The statement has been approved successfully.');
    }

    public function destroy($id){
        $payment_history = PaymentHistory::find($id);
        $user_id = $payment_history->user_id;
        $course_id = $payment_history->course_id;

        $course = Course::find($course_id);

        if(Gate::denies('my-course',$course)){
            return back()->with('error','Unauthorize');
        }

        $course->enroll_count = $course->enroll_count - 1;
        $course->save();
        
        SavedCourse::where('user_id',$user_id)->where('course_id',$course_id)->delete();

        $path = $payment_history->screenshort_url;
        if ($path) {
            Storage::disk('public')->delete($path); // Delete screenshot 
        }

        $payment_history->delete();

        NotificationController::store([
            'notification_type_id'=>23,
            'user_id'=>Auth::user()->id, // instructor (active person)
            'passive_user_id'=>$user_id, // student (passive person)
            'passive_user_type'=>3,
            'body'=>$course->title,
            'payload'=>[
                'course_id'=>$course_id,
                'payment_id'=>$id,
            ]
        ]);

        return back()->with('msg','The statement has been deleted successfully.');
    
    }

    public function show($id){
        $user = Auth::user();
        $payment_history = PaymentHistory::find($id);
        if($payment_history==null){
            return redirect(route('instructor.error'));
        }

        $instructor = Instructor::find($payment_history->instructor_id);
        if($instructor->user->id != $user->id){
            return redirect(route('instructor.error'));
        }

        return view('instructor.statement-detail',[
            'payment_history' =>$payment_history,
            'page_title'=>'Statement - Detail',
        ]);
    }
}
