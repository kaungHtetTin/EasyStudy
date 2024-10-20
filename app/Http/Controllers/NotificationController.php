<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(){
        return view('student.notifications',[
            'page_title'=>'Notifications',
        ]);
    }

    static function store($data){

        if($data['user_id']==$data['passive_user_type']);

        $notification = new Notification();
        $notification->notification_type_id = $data['notification_type_id']; //21
        $notification->user_id = $data['user_id'];
        $notification->passive_user_id = $data['passive_user_id'];
        $notification->body = $data['body'];
        $notification->passive_user_type = $data['passive_user_type'];
        $notification->payload = json_encode($data['payload']);
        $notification->seen = 0;
        $notification->save();

        // push notification to device
    }

    static function storeGroupNotification($data){
        $notification_type_id = $data['notification_type_id'];
        $user_id = $data['user_id'];
        $body =  $data['body'];
        $payload = json_encode($data['payload']);
        $users = $data['passive_users'];
        $passive_user_type = $data['passive_user_type'];

        $notifications = [];
        foreach($users as $user){
            if($user_id == $user->id) continue;
            $notifications [] = [
                'notification_type_id'=>$notification_type_id,
                'user_id'=>$user_id,
                'passive_user_id'=>$user->id,
                'passive_user_type'=>$passive_user_type,
                'body'=>$body,
                'payload'=>$payload,
                'seen'=>0,
                'created_at'=>now(),
                'updated_at'=>now(),
            ];
        }

        Notification::insert($notifications);
    }
}
