<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\User;

class UserController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        // Fetch Statistics
        $totalComments = Comment::where('user_id', $userId)->count();
        $totalRatings = Rating::where('user_id', $userId)->count();
        $totalResearchRead = Research::whereHas('ratings', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
        $totalPoints = auth()->user()->points;

        // User Activity Chart Data
        $userActivityData = Comment::where('user_id', $userId)
            ->selectRaw('DATE(date) as activity_date, COUNT(*) as total')
            ->groupBy('activity_date')
            ->pluck('total');
        $userActivityLabels = Comment::where('user_id', $userId)
            ->selectRaw('DATE(date) as activity_date')
            ->groupBy('activity_date')
            ->pluck('activity_date');

        // Research Category Distribution
        $researchCategoryCounts = Research::whereHas('ratings', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->selectRaw('fields, COUNT(*) as count')
            ->groupBy('fields')
            ->pluck('count', 'fields');

        // Recent Activity (Comments & Ratings)
        $recentActivity = Comment::where('user_id', $userId)
            ->select('content as description', 'date', 'research_id')
            ->addSelect(\DB::raw("'Comment' as type"))
            ->union(
                Rating::where('user_id', $userId)
                    ->select(\DB::raw("CONCAT('Rated ', rating_value, ' stars') as description"), 'date', 'research_id')
                    ->addSelect(\DB::raw("'Rating' as type"))
            )
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('front.user.dashboard', compact(
            'totalComments',
            'totalRatings',
            'totalResearchRead',
            'totalPoints',
            'userActivityData',
            'userActivityLabels',
            'researchCategoryCounts',
            'recentActivity'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('front.user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|min:8|confirmed',
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    public function commentsRatings()
    {
        $comments = Comment::where('user_id', Auth::id())->latest('date')->get();
        $ratings = Rating::where('user_id', Auth::id())->latest('date')->get();
        return view('front.user.commentsRatings', compact('comments', 'ratings'));
    }

    public function deleteComment(Request $request)
    {
        $comment = Comment::where('comment_id', $request->comment_id)->where('user_id', auth()->id())->first();
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Comment not found'], 404);
    }

    public function deleteRating(Request $request)
    {
        $rating = Rating::where('user_id', auth()->id())->where('research_id', $request->research_id)->first();
        if ($rating) {
            $rating->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Rating not found'], 404);
    }
}
