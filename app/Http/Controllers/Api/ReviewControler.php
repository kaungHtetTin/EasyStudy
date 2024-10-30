<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Reaction;

class ReviewControler extends Controller
{

    public function react(Request $req, $id) {
        $content_type = 2; // 1 for review
        $this->validate($req, [
            'react' => 'required|integer|in:1,2',
            'user_id' => 'required|integer'
        ]);
        
        $react = $req->react;
        $user_id = $req->user_id;

        $review = Review::find($id);
        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        // Check if the user has already reacted with the same reaction
        $existingReaction = Reaction::where('user_id', $user_id)
            ->where('content_id', $id)
            ->where('content_type', $content_type)
            ->where('react', $react)
            ->first();

        if ($existingReaction)  return response()->json(['success' => true]); // this is a little different to like and dislike

        // Remove any other existing reaction by the user on this content
        $previousReaction = Reaction::where('user_id', $user_id)
            ->where('content_id', $id)
            ->where('content_type', $content_type)
            ->first();

        if ($previousReaction) {
            if ($previousReaction->react == 1) {
                $review->like_count = max(0, $review->like_count - 1);
            } elseif ($previousReaction->react == 2) {
                $review->dislike_count = max(0, $review->dislike_count - 1);
            }
            $previousReaction->delete();
        }

        // Create a new reaction
        $newReaction = new Reaction();
        $newReaction->user_id = $user_id;
        $newReaction->content_id = $id;
        $newReaction->content_type = $content_type;
        $newReaction->react = $react;
        $newReaction->save();

        if ($react == 1) {
            $review->like_count += 1;
        } elseif ($react == 2) {
            $review->dislike_count += 1;
        }
        
        $review->save();

        return response()->json(['success' => true]);
    }
}
