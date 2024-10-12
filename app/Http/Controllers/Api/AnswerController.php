<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;

use App\Models\Answer;
use App\Models\Question;

class AnswerController extends Controller
{
    public function index(){
        return "all answers";
    }

    public function store(Request $req){
        $req->validate([
            'user_id'=>'required|numeric',
            'question_id'=>'required|numeric',
            'body'=>'required',
        ]);

        $answer = new Answer();
        $answer->user_id = $req->user_id;
        $answer->question_id = $req->question_id;
        $answer->body = $req->body;

        $question = Question::find($req->question_id);
        $question->answer_count = $question->answer_count + 1;
        $question->save();

        $answer->save();

        NotificationController::store([
            'notification_type_id'=>25,
            'user_id'=>$req->user_id, // (active person)
            'passive_user_id'=>$question->user_id, // (passive person)
            'body'=>"",
            'payload'=>[
                'question_id'=>$question->id,
                'course_id'=>$question->course_id,
            ]
        ]);

        return response()->json($answer, 201);
    }

    public function destroy(Request  $req, $id){
        $user = $req->user();
        $answer = Answer::find($id);
        if($answer==null){
            return response()->json("Bad Request",400);
        }
        $question = Question::find($answer->question_id);

        if($answer->user_id == $user->id){
            $question->answer_count = $question->answer_count - 1;
            $question->save();

            $answer->delete();
            return response()->json("success",200);
        }else{
            $course = Course::find($question->course_id);
            if($course->instructor->user->id == $user->id){
                
                $question->answer_count = $question->answer_count - 1;
                $question->save();

                $answer->delete();
                return response()->json("success",200);
            }else{
                return response()->json('Forbidden', 403);
            }
        }
    }
}
