<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(){
        $user = Auth::user();
        $notifications = Notification::with('user:id,name,email,image_url')
        ->where('passive_user_id',$user->id)
        ->where('notification_types.passive_user_type','instructor')
        ->join('notification_types','notification_types.id','=','notification_type_id')
        ->get();

        return $notifications;

        return view('instructor.notifications',[
            'page_title'=>"Notifications"
        ]);
    }
}
