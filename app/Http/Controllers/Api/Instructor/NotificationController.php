<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
     public function index(Request $req){
        $user = $req->user();

        if(isset($req->seen)){
            $seen = $req->seen;
            $notifications = Notification::with('notification_type:id,description,title,web_icon')
            ->with('user:id,name,email,image_url')
            ->where('passive_user_id',$user->id)
            ->where('passive_user_type',2)
            ->where('seen',$seen)
            ->orderBy('id','DESC')
            ->paginate(10);
            return response()->json($notifications);
        }

        $notifications = Notification::with('user:id,name,email,image_url')
        ->with('notification_type:id,description,title,web_icon')
        ->where('passive_user_id',$user->id)
        ->where('passive_user_type',2)
        ->orderBy('id','DESC')
        ->paginate(10);

        return response()->json($notifications);
       
    }

    public function update(Request $req,$id){
        $user = $req->user();
 
        $notification = Notification::where('passive_user_id',$user->id)->where('id',$id)->first();
        $notification->seen = 1;
        $notification->save();
        
        return response()->json($notification,200);
    }

    public function markAsReadAll(Request $req){
        $user = $req->user();
        Notification::where('passive_user_id',$user->id)->where('passive_user_type',2)->update(['seen'=>1]);

        return response()->json("success",200);
    }
}
