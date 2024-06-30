<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    //
    public function create(Request $req){

        $user = Auth::user();

        $validatedData = $req->validate([
        
            'course_id'=>'required',
            'question_type'=>'required',
            'question_title'=>'required',
            
        ]);

        $question = new Question();
        $question->user_id = $user->id;
        $question->course_id = $req->course_id;
        $question->question_type_id = $req->question_type;
        $question->body = $req->question_detail;
        $question->title = $req->question_title;

        $question->save();

        return redirect()->back()->with('status','Question successfully published');
    }
}
