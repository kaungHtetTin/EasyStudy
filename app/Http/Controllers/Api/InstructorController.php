<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Instructor;
use App\Models\Blog;
use App\Models\Bill;

class InstructorController extends Controller
{
    public function index(Request $req){

        $instructors = Instructor::with('user:id,name,email,phone,address,image_url')
        ->with('user.social_contacts')
        ->with('categories')->paginate(12);
        
        return $instructors;

    }



    public function blogs($id){
        $instructor = Instructor::find($id);
        $user = $instructor->user;
        $blogs = Blog::where('user_id',$user->id)->orderBy('id','DESC')->paginate(10);
        return response()->json($blogs);
    }

    public function search(Request $req){

        $req->validate([
            'q'=>'required',
        ]);

        $search_str = $req->q;

        $instructors = Instructor::selectRaw("instructors.*,users.name")
        ->with('user:id,name,email,phone,address,image_url')
        ->with('user.social_contacts')
        ->with('categories')
        ->join('users','users.id','=','instructors.user_id')
        ->where('users.name','like','%'.$search_str.'%')
        ->paginate(24);

        return response()->json($instructors);
    }
}
