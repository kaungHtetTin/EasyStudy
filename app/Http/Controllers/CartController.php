<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\PaymentMethodType;
use App\Models\Category;
use App\Models\SavedCourse;

class CartController extends Controller
{
    public function detail(){
        
        $payment_method_types = PaymentMethodType::all();
        return view('cart',[
            'page_title'=>'Cart',
            'payment_method_types'=>$payment_method_types,
        ]);
     
    }   

    public function create(Request $req){

        $course_id = $req->course_id;
        $user = Auth::user();

        $myCourse = SavedCourse::where('user_id',$user->id)->where('course_id',$course_id)->first();

        if($myCourse){
            return redirect()->route('mycourses');
        }
        
        Cart::firstOrCreate(
            [                                   // Attributes to check
                'user_id' => $user->id,
                'course_id'=>$course_id
            ], 
            [                                    // Attributes to set if record does not exist
                'user_id' => $user->id,
                'course_id'=>$course_id
            ]
        );

        return redirect()->route('cart');
    }

    public function destroy($id){
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart')->with('success', 'Resource deleted successfully.');
    }
}
