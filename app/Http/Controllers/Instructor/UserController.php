<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function message($id){
        $user = User::find($id);
        if($user == null) return redirect(route('instructor.error'));
        $block = Block::where('user_id',$id)->where('my_id',Auth::user()->id)->first();
        if(!$block) $block = Block::where('my_id',$id)->where('user_id',Auth::user()->id)->first();
        return view('instructor.chatroom-message',[
            'page_title' => "Chatting",
            'other' => $user,
            'block' => $block,
        ]);
    }
}
