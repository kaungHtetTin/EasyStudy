<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Answer;
use App\Models\Question;

class AnswerController extends Controller
{
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
        return response()->json($answer, 201);
    }
}
