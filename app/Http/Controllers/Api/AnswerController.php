<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

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

        $course = Course::find($question->course_id);

        NotificationController::store([
            'notification_type_id'=>25,
            'user_id'=>$req->user_id, // (active person)
            'passive_user_id'=>$question->user_id, // (passive person)
            'passive_user_type'=>3,
            'body'=>$course->title,
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
        $course = Course::find($question->course_id);

        $permission_granted = false;

        $permission_granted = $user->id === $answer->user_id;

        if(!$permission_granted) $permission_granted = $user->id === $course->instructor->user->id;

        if(!$permission_granted)  return response()->json("Forbidden",403);
 
        $htmlString = $answer->body;
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $htmlString, $matches);
        foreach ($matches[1] as $src) {
            $old_path = strchr($src,"images/");
            if ($old_path) {
                $images = "image found";
                Storage::disk('public')->delete($old_path); // Delete old image
            }
        }

        $question->answer_count = $question->answer_count - 1;
        $question->save();

        $answer->delete();
        
        return response()->json("success",200);

    }
}
