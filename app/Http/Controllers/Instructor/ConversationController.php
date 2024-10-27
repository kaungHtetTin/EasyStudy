<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;
use App\Models\Block;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index(){
        return view('instructor.chatrooms',[
            'page_title'=>'Messages',
        ]);
    }

    public function show($id){

        $conversation = Conversation::find($id);
        if(!$conversation) {
            return $this->index();
        }
        if(Gate::denies('my-conversation',$conversation)){
             return redirect(route('instructor.error'));
        }
        $user = User::find($conversation->user_id);
        $block = Block::where('user_id',$conversation->user_id)->where('my_id',$conversation->my_id)->first();
        if(!$block) $block = Block::where('my_id',$conversation->user_id)->where('user_id',$conversation->my_id)->first();
        return view('instructor.chatroom-message',[
            'page_title' => "Chatting",
            'other' => $user,
            'conversation'=>$conversation,
            'block'=>$block,
        ]);  
    }

    public function destroy(Request $req){
        
        $req->validate([ 
            'user_id'=>'required',
        ]);
        $user = Auth::user();

        $conversation = Conversation::where('user_id',$req->user_id)->where('my_id',$user->id)->first();

        Message::where('user_id',$conversation->user_id)->where('my_id',$conversation->my_id)->delete();
        $conversation->delete();

        return redirect(route('instructor.chatrooms.lists'))->with('msg','The conversation was successfully deleted');

    }
}
