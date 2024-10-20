<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Question;
use App\Models\Course;

class QuestionController extends Controller
{
    
    public function uploadPhoto (Request $request){
    
        $request->validate([
            'image_file'=>'required|mimes:jpeg,png,jpg,gif,JPG,PNG|max:10485760',
        ]);

    
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            $path = $image->store('images/questions', 'public');
            return response()->json($path, 201);
        }
        return response()->json("error",400);

    }

    public function destroy(Request $req, $id){
        $user = $req->user();
        $question = Question::find($id);

        if($question == null){
            return response()->json("Bad Request",400);
        }

        $course = Course::find($question->course_id);

        $permission_granted = $question->user_id == $user->id;
        if(!$permission_granted) $permission_granted = $course->instructor->user->id == $user->id;

        if(!$permission_granted) return response()->json('Forbidden', 403);

        $this->deleteImageInHtmlString($question->body);
        foreach($question->answers as $answer){
            $this->deleteImageInHtmlString($answer->body);
        }
        
        $question->delete();

        return response()->json("success",200);
    }

    public function deleteImageInHtmlString($htmlString){
        preg_match_all('/<img[^>]+src="([^">]+)"/i', $htmlString, $matches);
        foreach ($matches[1] as $src) {
            $old_path = strchr($src,"images/");
            if ($old_path) {
                $images = "image found";
                Storage::disk('public')->delete($old_path); // Delete old image
            }
        }
    }
}
