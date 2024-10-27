<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;

class ConversationController extends Controller
{
    public function index(Request $req){
        $user = $req->user();

        $conversations = Conversation::with('user:id,name,email,image_url,fcm_token')
        ->where('my_id',$user->id);

        if(isset($req->seen)){
           $conversations = $conversations->where('seen',$req->seen);
        }

        $conversations = $conversations
        ->orderBy('updated_at','desc')
        ->paginate(30);

        return response()->json($conversations);
    }

    public function destroy(){

    }


}
