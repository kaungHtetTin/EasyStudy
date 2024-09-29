<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;
use App\Models\PaymentMethod;

class LayoutController extends Controller
{
    public function index(){

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        if($instructor){
             $payment_methods = PaymentMethod::where('instructor_id',$instructor->id)->get();
            return view('instructor.dashboard',[
                'page_title'=>'Dashboard',
                'payment_methods'=>$payment_methods,
            ]);
        }else{
            return view('pages.teach-on',[
                'page_title'=>'Teach On',
            ]);
        }
    }

    public function error(){
        return view('instructor.error',[
            'page_title'=>"Error",
        ]);
    }
}
