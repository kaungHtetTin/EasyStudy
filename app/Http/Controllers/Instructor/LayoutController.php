<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;

class LayoutController extends Controller
{
    public function index(){

        $user = Auth::user();
        $instuctor = Instructor::where('user_id',$user->id);
        if($instuctor){
            return view('instructor.dashboard',[
                'page_title'=>'Dashboard',
            ]);
        }else{
            return view('pages.teach-on',[
                'page_title'=>'Teach On',
            ]);
        }
    }

    public function courseCreate(){
        
       return "error";

    }
}
