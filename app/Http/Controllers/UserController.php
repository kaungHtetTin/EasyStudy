<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('user',['users'=>$users]);
    }

    public function message($id){
        $user = User::find($id);
        if($user == null) return redirect(route('student.error'));
        $block = Block::where('user_id',$id)->where('my_id',Auth::user()->id)->first();
        if(!$block) $block = Block::where('my_id',$id)->where('user_id',Auth::user()->id)->first();
        return view('student.chatroom-message',[
            'page_title' => "Chatting",
            'other' => $user,
            'block'=>$block,
        ]);
    }
    
    public function block($id){
        $user = Auth::user();
        $blocked_user = User::find($id);
        if($blocked_user){
            $block = new Block();
            $block->user_id = $blocked_user->id;
            $block->my_id = $user->id;
            $block->save();

            return back()->with('msg','The user was successfully blocked on messageing');
        }else{
            return back()->with('error','An unexpected error occurred');
        }
    }

    public function unblock($id){
        $user = Auth::user();
        Block::where('my_id',$user->id)->where('user_id',$id)->delete();
        return back()->with('msg','The user was successfully unblocked on messageing');
        
    }
}
