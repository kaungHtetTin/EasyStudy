<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Instructor;
use App\Models\SocialMedia;
use App\Models\SocialContact;
use App\Models\Category;

class ProfileController extends Controller
{

    public function edit(){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $social_media = SocialMedia::get();
        $categories = Category::all();
    
        return view('instructor.instructor-profile-edit',[
            'page_title'=>"Profile Edit",
            'instructor'=>$instructor,
            'social_media'=>$social_media,
            'categories'=>$categories,
        ]);
    }

    public function update(Request $req){
        $req->validate([
            'about'=>'required',
        ]);

        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $instructor->about = $req->about;
        $instructor->save();

        return back()->with('msg','Successfully updated');
    }

    public function addSocialContact(Request $req){
        $req->validate([
            'link'=>'required',
            'social_media_id'=>'required|numeric',
        ]);
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        $social_contact = new SocialContact();
        $social_contact->user_id = $user->id;
        $social_contact->social_media_id = $req->social_media_id;
        $social_contact->link = $req->link;
        $social_contact->save();

        return back()->with('msg','New Social contact was successfully added');
    }

    public function removeSocialContact($contact_id){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $social_contact = SocialContact::find($contact_id);
        if($social_contact==null){
            return redirect(route('instructor.error'));
        }
        if($social_contact->user_id != $user->id){
            return redirect(route('instructor.error'));
        }
        $social_contact->delete();
        return back()->with('msg','The contact was successfully deleted');
    }

    public function addCategory(Request $req){
        $req->validate([
            'category_id'=>'required|numeric',
        ]);
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();

        DB::table('category_instructor')->insert(['category_id'=>$req->category_id, 'instructor_id'=>$instructor->id]);
        return back()->with('msg','New subject category was successfully added');
    }

    public function removeCategory($category_id){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        DB::table('category_instructor')->where('category_id',$category_id)->where('instructor_id',$instructor->id)->delete();
        return back()->with('msg','The category was successfully deleted');
    }
}
