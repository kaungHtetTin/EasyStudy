<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;
use App\Models\SocialMedia;
use App\Models\SocialContact;

class ProfileController extends Controller
{
    public function index(){

    }

    public function edit(){
        $user = Auth::user();
        $instructor = Instructor::where('user_id',$user->id)->first();
        $social_media = SocialMedia::get();
    
        return view('instructor.instructor-profile-edit',[
            'page_title'=>"Profile Edit",
            'instructor'=>$instructor,
            'social_media'=>$social_media,
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

        return back()->with('msg','New Social contact is successfully added');
    }
}
