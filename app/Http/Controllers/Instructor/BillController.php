<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;
use App\Models\PaymentMethod;
use App\Models\PaymentHistory;
use App\Models\Setting;
use App\Models\Bill;


class BillController extends Controller
{
    public function index(){
        $payout_percent = Setting::where('setting','payout_percent')->first();
        $payout_percent = $payout_percent->value;

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
      
        $payment_histories = PaymentHistory::where('instructor_id',$instructor->id)
        ->where('billed',0)
        ->get();

        // define payout period
        if(count($payment_histories)==0){
            $first_id = 0;
            $last_id = 0;
        }elseif(count($payment_histories)==1){
            $first_id = $payment_histories[0]->id;
            $last_id  = $payment_histories[0]->id;
        }else{
            $first_id = $payment_histories[0]->id;
            $last_id  = $payment_histories[count($payment_histories)-1]->id;
        }

        $income_amount = $payment_histories->sum('amount');

        $billed_amount = $income_amount * ($payout_percent/100);

        $next_month = $this->getNextMonth( date('Y'), date('m'));

        $payout_method = Setting::where('setting','payout_method')->first();
        $payout_methodJSON = $payout_method->value; 
        $payout_methods = json_decode($payout_methodJSON,true); // this is array , not model 

        return view('instructor.bills',[
            'page_title' => 'Payout',
            'billed_amount'=>$billed_amount,
            'next_month' => $next_month,
            'payout_methods' => $payout_methods,
            'history_from' => $first_id,
            'history_to'=>$last_id,
        ]);
    }

    public function store(Request $req){ 

        $req->validate([
            'history_from'=>'required',
            'history_to'=>'required',
            'screenshot'=>'required',
        ]);

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        $payout_percent = Setting::where('setting','payout_percent')->first();
        $payout_percent = $payout_percent->value;

        $income_amount = PaymentHistory::where('instructor_id',$instructor->id)
        ->where('billed',0)
        ->where('id','>=',$req->history_from)
        ->where('id','<=',$req->history_to)
        ->sum('amount');

        $billed_amount = $income_amount * ($payout_percent/100);
        
        if($billed_amount==0){
            return back()->with('error','Unexpected error');
        }

        $screenshot_url = "";
        if($req->hasFile('screenshot')){
            $screenshot = $req->file('screenshot');
            $screenshot_url = $screenshot->store('images/bills', 'public');
        }

        if($screenshot_url==""){
            return back()->with('error','Unexpected error');
        }else{
            $bill = new Bill();
            $bill->instructor_id = $instructor->id;
            $bill->amount = $billed_amount;
            $bill->screenshot_url = $screenshot_url;
            $bill->history_from = $req->history_from;
            $bill->history_to = $req->history_to;
            $bill->save();

            PaymentHistory::where('instructor_id',$instructor->id)
            ->where('billed',0)
            ->where('id','>=',$req->history_from)
            ->where('id','<=',$req->history_to)
            ->update(['billed'=>1]);

            return back()->with('msg','Your payout transaction was successfully sent.');
        }
    }

    function getNextMonth($year, $month){
        $month++;
        if($month==12){
            $month=1;
            $year++;
        }
        $result['year']=$year;
        $result['month']=$month;
        return $result;
    }
}
