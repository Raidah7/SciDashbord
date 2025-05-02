<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Researcher;

class ResearcherController extends Controller
{
    public function dashboard()
    {
        $researcherId = Auth::id();

        $totalResearch = Research::where('submitted_by', $researcherId)->count();
        $totalComments = Comment::whereIn('research_id', Research::where('submitted_by', $researcherId)->pluck('research_id'))->count();
        $totalRatings = Rating::whereIn('research_id', Research::where('submitted_by', $researcherId)->pluck('research_id'))->count();
        $totalApprovedResearch = Research::where('submitted_by', $researcherId)->where('status', 'Approved')->count();

        $recentComments = Comment::whereIn('research_id', Research::where('submitted_by', $researcherId)->pluck('research_id'))
            ->latest('date')->take(5)->get();

        $recentRatings = Rating::whereIn('research_id', Research::where('submitted_by', $researcherId)->pluck('research_id'))
            ->latest('date')->take(5)->get();

        $researchStatusCounts = Research::where('submitted_by', $researcherId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $averageRatings = Rating::whereIn('research_id', Research::where('submitted_by', $researcherId)->pluck('research_id'))
            ->avg('rating_value');

        return view('researcher.dashboard', compact(
            'totalResearch', 'totalComments', 'totalRatings', 'totalApprovedResearch',
            'recentComments', 'recentRatings', 'researchStatusCounts', 'averageRatings'
        ));
    }

    public function profile()
    {
        $researcher = Auth::user()->researcher;
        return view('researcher.profile', compact('researcher'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'institution' => 'nullable|string|max:255',
            'expertise' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password ? Hash::make($request->password) : $user->password,
                ]);
                if ($user->researcher) {
                    $user->researcher->update([
                        'institution' => $request->institution,
                        'expertise' => $request->expertise,
                    ]);
                }
            });
            return redirect()->route('researcher.profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, please try again.')->withInput();
        }
    }

    public function listComments()
    {
        $researchIds = Research::where('submitted_by', Auth::id())->pluck('research_id');
        $comments = Comment::whereIn('research_id', $researchIds)->orderBy('date', 'desc')->get();

        return view('researcher.comments', compact('comments'));
    }

    public function listRatings()
    {
        $researchIds = Research::where('submitted_by', Auth::id())->pluck('research_id');
        $ratings = Rating::whereIn('research_id', $researchIds)->orderBy('date', 'desc')->get();

        return view('researcher.ratings', compact('ratings'));
    }
}
