<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
    public function delete(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'User not found'], 404);
    }


    public function comments()
    {
        $comments = Comment::with('user', 'research')->latest('date')->get();
        return view('admin.comments', compact('comments'));
    }

    public function deleteComment(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Comment not found'], 404);
    }

    public function ratings()
    {
        $ratings = Rating::with('user', 'research')->latest('date')->get();
        return view('admin.ratings', compact('ratings'));
    }

    public function deleteRate(Request $request)
    {
        $rating = Rating::where('user_id', $request->user_id)->where('research_id', $request->research_id)->first();
        if ($rating) {
            $rating->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Rating not found'], 404);
    }
}
