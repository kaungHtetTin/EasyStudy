<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Category;

class CartController extends Controller
{
    public function detail(){

        $categories = Category::all();
        return view('cart',[
            'page_title'=>'cart',
            'categories'=>$categories,
        ]);
     
    }   

    public function create(Request $req){

        $course_id = $req->course_id;
        $user = Auth::user();

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

        return view('cart',[
            'page_title'=>'cart'
        ]);
    }

    public function destroy($id){
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart')->with('success', 'Resource deleted successfully.');
    }
}
