<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bill;
use App\Models\Instructor;

class BillController extends Controller
{
    public function index(Request $req){
        $user = $req->user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        $bills = Bill::where('instructor_id',$instructor->id)
        ->orderBy('id','desc')
        ->paginate(10);

        return $bills;

    }
}
