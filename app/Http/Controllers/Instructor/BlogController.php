<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use App\Models\Instructor;
use Illuminate\Support\Facades\Gate;

class BlogController extends Controller
{
    public function index(){
        return view('instructor.blogs',[
            'page_title'=>'My Blog',
        ]);
    }

    public function create(){
        return view('instructor.blog-create',[
            'page_title'=>'Create Blog',
        ]);
    }

    public function store(Request $req){
        $user = Auth::user();
 
        $req->validate([
            'title'=>'required',
            'description'=>'required',
            'summary'=>'required',
        ]);

        
        $blog = new Blog();
        $blog->user_id = $user->id;
        $blog->title = $req->title;
        $blog->summary = $req->summary;
        $blog->body = $req->description;
        
        $cover_image_path = "";
        if($req->hasFile('cover_image')){
            $image = $req->file('cover_image');
            $cover_image_path = $image->store('images/blogs','public');
        }
        $blog->image_url = $cover_image_path;
        $blog->save();

        $instructor = Instructor::where('user_id',$user->id)->first();
        $subscribers =  $instructor->subscribers;

        NotificationController::storeGroupNotification([
            'notification_type_id'=>42, // add new blog
            'user_id'=>$user->id, // (active person)
            'passive_users'=>$subscribers, // (passive people)
            'body'=>$req->title,
            'passive_user_type'=>3,
            'payload'=>[
                'blog_id'=>$blog->id,
                'instructor_id'=>$instructor->id,
            ]
        ]);

        return back()->with('msg','New blog was successfully added.');

    }

    public function show($id){
        $blog = Blog::find($id);
        if(Gate::denies('my-blog',$blog)){
            return redirect(route('instructor.error'));
        }
        return view('instructor.blog-detail',[
            'page_title'=>'Blog Detail',
            'blog'=>$blog,
        ]);
    }

    public function edit($id){
        $blog = Blog::find($id);
        if(Gate::denies('my-blog',$blog)){
            return redirect(route('instructor.error'));
        }
        return view('instructor.blog-edit',[
            'page_title'=>'Edit Blog',
            'blog'=>$blog,
        ]);
    }

    public function update(Request $req, $id){
        $req->validate([
            'title'=>'required',
            'description'=>'required',
            'summary'=>'required',
        ]);

        $blog = Blog::find($id);
        if(Gate::denies('my-blog',$blog)){
            return redirect(route('instructor.error'));
        }

        $blog->title = $req->title;
        $blog->summary = $req->summary;
        $blog->body = $req->description;

        if($req->hasFile('cover_image')){

            $old_url = $blog->image_url;

            $image = $req->file('cover_image');
            $cover_image_path = $image->store('images/blogs','public');
            $blog->image_url = $cover_image_path;

            if ($old_url) {
                Storage::disk('public')->delete($old_url); // Delete old image
            }

        }

        $blog->save();

        return back()->with('msg','The blog was successfully updated.');
    }

    public function destroy($id){
        $blog = Blog::find($id);
        if(Gate::denies('my-blog',$blog)){
            return redirect(route('instructor.error'));
        }

        $image_url = $blog->image_url;
        if ($image_url) {
            Storage::disk('public')->delete($image_url); // Delete old image
        }

        // delete image in body

        $blog->delete();

        return back()->with('msg','The blog was successfully deleted.');
    }
}
