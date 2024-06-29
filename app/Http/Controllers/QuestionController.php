<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    //
    public function create(Request $req){

        $user = Auth::user();

        $validatedData = $req->validate([
            'input_question' => 'required',
            'question_type_id'=>'required',
            'lesson_id'=>'required',
            'question_id'=>'required',
            'body'=>'required',
            
        ]);

        $question = new Question();
        $question->user_id = $user->id;
        $question->lesson_id = $req->lesson_id;
        $question->question_type_id = $req->question_type_id;
        $question->question_id = $req->question_id;


    }
}
