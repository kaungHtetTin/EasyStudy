<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LearningHistory;
use Illuminate\Http\Request;

class LearningHistoryController extends Controller
{
    //

    public function create(Request $req){
    
        $user = $req->user();
        $lesson_id = $req->lesson_id;

        $history = LearningHistory::where('user_id',$user->id)->where('lesson_id',$lesson_id)->first();
         
        if($history){
            $history->frequent = $history->frequent + 1;
            $history->save();
        }else{
            $newHistory = new LearningHistory();
            $newHistory->user_id = $user->id;
            $newHistory->lesson_id = $lesson_id;
            $newHistory->frequent = 1;
            $newHistory->save();
        }

        return "Successfully set learning record";
    }
}
