<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Instructor;
use App\Models\User;
use App\Models\PaymentMethodType;
use App\Models\Course;


class PaymentMethodController extends Controller
{


    public function index(){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $payment_methods = PaymentMethod::where('instructor_id',$instructor->id)->get();
        $payment_method_types = PaymentMethodType::all();
        return view('instructor.payment-methods',[
            'payment_methods'=>$payment_methods,
            'page_title'=>'Payment Methods',
            'payment_method_types'=>$payment_method_types,
        ]);
    }

    public function store(Request $req){
        $req->validate([
            'payment_method_type_id'=>'required|numeric',
            'phone'=>'required',
            'acc_name'=>'required',
        ]);

        $phone = $req->phone;
        $phone = str_replace(' ', '', $phone);
        $payment_method_type_id = $req->payment_method_type_id;
        $acc_name = $req->acc_name;
   
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        $payment_method = new PaymentMethod();
        $payment_method->instructor_id = $instructor->id;
        $payment_method->payment_method_type_id = $payment_method_type_id;
        $payment_method->method = $phone;
        $payment_method->account_name = $acc_name;
        $payment_method->save();

        return back()->with('success_msg','New payment method added successfully');

    }

    public function destroy($id){
        PaymentMethod::find($id)->delete();
        return back()->with('success_msg','Payment method deleted successfully');
    }
}
