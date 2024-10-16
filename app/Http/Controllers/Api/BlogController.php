<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
     public function uploadPhoto (Request $request){
    
        $request->validate([
            'image_file'=>'required|mimes:jpeg,png,jpg,gif,JPG,PNG|max:10485760',
        ]);

    
        if ($request->hasFile('image_file')) {
            $image = $request->file('image_file');
            $path = $image->store('images/blogs', 'public');
            return response()->json($path, 201);
        }
        return response()->json("error",400);

    }
}
