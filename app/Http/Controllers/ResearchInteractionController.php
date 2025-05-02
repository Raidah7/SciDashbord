<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Research;

class ResearchInteractionController extends Controller
{
    public function storeComment(Request $request, $id)
    {
        $request->validate(['content' => 'required|string|max:500']);

        Comment::create([
            'user_id' => Auth::id(),
            'research_id' => $id,
            'content' => $request->content,
            'date' => now(),
        ]);
        return back()->with('success', 'Your comment has been posted.');
    }

    public function storeRating(Request $request, $id)
    {
        $request->validate(['rating_value' => 'required|integer|min:1|max:5']);
        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'research_id' => $id],
            ['rating_value' => $request->rating_value, 'date' => now()]
        );
        return back()->with('success', 'Your rating has been recorded.');
    }

    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'rating_value' => 'required|integer|min:1|max:5',
            'comment_content' => 'required|string|max:500'
        ]);

        $rating = Rating::where('user_id', Auth::id())
            ->where('research_id', $id)
            ->first();

        if ($rating) {
            $rating->update([
               'rating_value' => $request->rating_value,
               'date' => now()
            ]);
        } else {
            Rating::create([
                'user_id' => Auth::id(),
                'research_id' => $id,
                'rating_value' => $request->rating_value,
                'date' => now()
            ]);

        }
        Comment::create([
            'user_id' => Auth::id(),
            'research_id' => $id,
            'content' => $request->comment_content,
            'date' => now()
        ]);

        return back()->with('success', 'Your feedback has been recorded.');
    }
}
