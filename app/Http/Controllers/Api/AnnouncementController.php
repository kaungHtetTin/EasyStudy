<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use App\Models\Course;

class AnnouncementController extends Controller
{
    public function destroy(Request $req, $id){
        $user = $req->user();
        $announcement = Announcement::find($id);
        if($announcement==null){
            return response()->json("Bad Request",400);
        }

        $course = Course::find($announcement->course_id);
        if($course->instructor->user->id == $user->id){
            $image_url = $announcement->image_url;
            $resource_url = $announcement->resource_url;
            if($image_url)  Storage::disk('public')->delete($image_url);
            if($resource_url)  Storage::disk('public')->delete($resource_url);
            $announcement->delete();
            return response()->json("success",200);
        }else{
            return response()->json('Unauthorized', 403);
        }
    }
}
