<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Course;

class ReviewController extends Controller
{
    public function create(Request $req){
        $validatedData = $req->validate([
            'star' => 'required|integer|min:1|max:5',
        ]);

        $review = new Review();
        $review->user_id = $req->user_id;
        $review->course_id = $req->course_id;
        $review->body = $req->review;
        $review->star = $req->star;
        $review->save();

        $totalStar = Review::where('course_id',$req->course_id)->sum('star');   // total star offered by all user for a course
        $totalRater = Review::where('course_id',$req->course_id)->count();

        $course = Course::findOrFail($req->course_id);
        $course->rating_count = $totalRater;
        $course->rating = $totalStar/$totalRater;
        $course->save();

        return redirect()->back()->with('review_added', 'Review added successfully!');
    }

    public function update(Request $req){
        $validatedData = $req->validate([
            'star' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::findOrFail($req->id);
        $review->body = $req->review;
        $review->star = $req->star;
        $review->save();

        $totalStar = Review::where('course_id',$req->course_id)->sum('star');   // total star offered by all user for a course
        $totalRater = Review::where('course_id',$req->course_id)->count();

        $course = Course::findOrFail($req->course_id);
        $course->total_rating = $totalRater;
        $course->rating = $totalStar/$totalRater;
        $course->save();

        return redirect()->back()->with('review_added', 'Review updated successfully!');
    }

    public function destroy($id){
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->back()->with('review_added', 'Review deleted successfully.');
    }
}
