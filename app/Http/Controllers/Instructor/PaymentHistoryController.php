<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Instructor;
use App\Models\PaymentHistory;
use App\Models\SavedCourse;

class PaymentHistoryController extends Controller
{
    public function index(Request $req){

        if(isset($req->verified)) $verified = $req->verified;
        else $verified = 0;

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $payment_histories = PaymentHistory::where('instructor_id',$instructor->id)->where('verified',$verified)->get();

        return view('instructor.statements',[
            'page_title'=>'Statements',
            'payment_histories'=>$payment_histories,
            'verified'=>$verified,
        ]);
    }

    public function update(Request $req,$id){
        $req->validate([
            'verified'=>'required|numeric',
        ]);

        $payment_history = PaymentHistory::find($id);
        $payment_history->verified = 1;
        $payment_history->save();

        $user_id = $payment_history->user_id;
        $course_id = $payment_history->course_id;

        $savedCourse = SavedCourse::where('user_id',$user_id)->where('course_id',$course_id)->first();
        $savedCourse->verified = 1;
        $savedCourse->save();
        
        return back()->with('msg','The statement has been approved successfully.');
    }

    public function destroy($id){
        $payment_history = PaymentHistory::find($id);
        $user_id = $payment_history->user_id;
        $course_id = $payment_history->course_id;

        SavedCourse::where('user_id',$user_id)->where('course_id',$course_id)->delete();

        $path = $payment_history->screenshort_url;
        if ($path) {
            Storage::disk('public')->delete($path); // Delete screenshot 
        }

        $payment_history->delete();

        return back()->with('msg','The statement has been deleted successfully.');
    
    }
}
