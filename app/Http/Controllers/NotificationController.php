<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    static function store($data){
        $notification = new Notification();
        $notification->notification_type_id = $data['notification_type_id']; //21
        $notification->user_id = $data['user_id'];
        $notification->passive_user_id = $data['passive_user_id'];
        $notification->body = $data['body'];
        $notification->payload = json_encode($data['payload']);
        $notification->save();

        // push notification to device
    }
}
