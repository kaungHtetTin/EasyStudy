<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index(Request $req){
        $user = $req->user();
        $my_id = $user->id;
        $other_id = $req->other_id;

        $conversation = Conversation::where('my_id',$my_id)->where('user_id',$other_id)->first();
        if($conversation!=null){
            $conversation->new_message_count = 0;
            $conversation->seen = 1;
            $conversation->save();
        }

        Message::where('my_id',$other_id)->where('user_id',$my_id)->where('seen',0)->update(['seen'=>1]);

        $messages =  Message::with('user:id,name,image_url,fcm_token')
        ->where('my_id',$my_id)
        ->where('user_id',$other_id)
        ->orderBy('id','desc')
        ->paginate(10);

        return response()->json($messages);
    }

    public function refresh(Request $req){
        $user = $req->user();
        $my_id = $user->id;
        $other_id = $req->other_id;
        $last_message_id = $req->last_message_id;
        Message::where('my_id',$other_id)->where('user_id',$my_id)->where('seen',0)->update(['seen'=>1]);

        $messages =  Message::with('user:id,name,image_url,fcm_token')
        ->where('my_id',$my_id)
        ->where('user_id',$other_id)
        ->where('sender_id',$other_id)
        ->where('id','>',$last_message_id)
        ->get();

        return $messages;
    }

    public function store(Request $req){
        $user = $req->user();
        $req->validate([
            'other_id'=>'required',
        ]);

        $other_id = $req->other_id;
        $content_exist = false;
        if (isset($req->message)) {
            $msg = $req->message;
            $content_exist = true;
        }else{
            $msg = "";
        }

        if($req->hasFile('image')){
            $content_exist = true;
            $image = $req->file('image');
            $image_url = $image->store('images/messages', 'public');
        }else{
            $image_url = "";
        }

        if(!$content_exist) return response()->json('Bad Request', 400);

        $message1 = new Message();
        $message1->user_id = $other_id;
        $message1->my_id = $user->id;
        $message1->sender_id = $user->id;
        $message1->message = $msg;
        $message1->image_url = $image_url;
        $message1->save();

        $message2 = new Message();
        $message2->my_id = $other_id;
        $message2->user_id = $user->id;
        $message2->sender_id = $user->id;
        $message2->message = $msg;
        $message2->image_url = $image_url;
        $message2->save();

        $my_conservation = Conversation::where('user_id',$other_id)->where('my_id',$user->id)->first();

        if(strlen($msg)>200){
            $msg = substr($msg,0,200);
        }

        if($msg == ""){
            $msg = "Sent you an image...";
        }

        if($my_conservation==null){
            $conversation = new Conversation();
            $conversation->user_id = $other_id;
            $conversation->my_id = $user->id;
            $conversation->message = 'You: '.$msg;
            $conversation->new_message_count =0;
            $conversation->seen = 1;
            $conversation->save();
        }else{
            $my_conservation->message = 'You: '.$msg;
            $my_conservation->new_message_count =0;
            $my_conservation->seen = 1;
            $my_conservation->save();
        }
        $other_conservation = Conversation::where('user_id',$user->id)->where('my_id',$other_id)->first();
        if($other_conservation==null){
            $conversation = new Conversation();
            $conversation->my_id = $other_id;
            $conversation->user_id = $user->id;
            $conversation->message = $msg;
            $conversation->new_message_count =1;
            $conversation->seen = 0;
            $conversation->save();
        }else{
            $other_conservation->message = $msg;
            $other_conservation->new_message_count = $other_conservation->new_message_count + 1;
            $other_conservation->seen = 0;
            $other_conservation->save();
        }
 
        return response()->json($message1,201);

    }
}
