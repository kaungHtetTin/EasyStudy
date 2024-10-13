<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(){

        return view('instructor.notifications',[
            'page_title'=>"Notifications"
        ]);
    }
}
