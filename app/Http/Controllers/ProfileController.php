<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instructor;
use App\Models\Course;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('student.edit-profile', [
            'page_title'=>'Edit Profile',
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $year = $request->year;
        $month = $request->month;
        $day = $request->day;

        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->bio = $request->bio;
        $user->education = $request->education;
        $user->address = $request->address;
        $user->gender = $request->gender;
        if($year!=null && $month!=null && $day!=null){
            $date = Carbon::createFromFormat('Y-m-d H:i:s', "$year-$month-$day 00:00:00");
            $user->birth_date  = $date;
        }
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Your profile information is uploaded successfully.');

    }

    public function updateImage(Request $request){
        $user = Auth::user();

        $validatedData = $request->validate([
            'profile_image' => 'required|mimes:jpeg,png,jpg,gif,JPG,PNG|max:10485760',
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $path = $image->store('images/profiles', 'public');
            $user->image_url = $path;
            $user->save();
            return Redirect::route('profile.edit')->with('status', 'Upload your image successfull.');
        }
        return Redirect::route('profile.edit')->with('status', 'Image upload fail');

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'Your profile information is uploaded successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $instructor = Instructor::where('user_id',$user->id)->first();
        if($instructor){
            $id = $instructor->id;
            $instructor->user_id = 1;
            $instructor->save();

            Course::where('instructor_id',$id)->update(
                ['disable'=>1]
            );
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
