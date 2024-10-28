<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instructor;

class SubscriberController extends Controller
{
    public function subscriptions(Request $req){
        $user = $req->user();
        $instructors = Instructor::selectRaw('instructors.*')
        ->with('user:id,name,email,phone,address,image_url')
        ->with('user.social_contacts')
        ->with('categories')
        ->join('subscribers','subscribers.instructor_id','=','instructors.id')
        ->where('subscribers.user_id',$user->id)
        ->paginate(12);
        
        return $instructors;
    }

    public function search(Request $req){

        $req->validate([
            'q'=>'required'
        ]);

        $search_str = $req->q;

        $user = $req->user();
        $instructors = Instructor::selectRaw('instructors.*')
        ->with('user:id,name,email,phone,address,image_url')
        ->with('user.social_contacts')
        ->with('categories')
        ->join('subscribers','subscribers.instructor_id','=','instructors.id')
        ->join('users','users.id','=','instructors.user_id')
        ->where('subscribers.user_id',$user->id)
        ->where('users.name','like','%'.$search_str.'%')
        ->paginate(12);
        
        return $instructors;
    }   
}
