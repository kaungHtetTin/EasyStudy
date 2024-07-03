<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Models\LearningHistory;

class LearningHistoryController extends Controller
{
    public function create(Request $req){

        return "hello world";

        $user = $req->user();
        return $user;

        $lesson_id = $req->lesson_id;

        LearningHistory::updateOrCreate(
            ['user_id'=>$user_id, 'course_id'=>$course_id],
            ['frequest'=>new Expression('frequest + 1')]
        );

        return "Learning History Update successfully";

    }
}
