<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{

    public function destroy($id){
        $lesson = Lesson::find($id);

        // unlink video
        $link = $lesson->link;
        if ($link) {
            Storage::disk('public')->delete($link ); // Delete old image
        }

        $lesson->delete();
        return back()->with('msg',"Lesson has been deleted successfully");
    }
}
