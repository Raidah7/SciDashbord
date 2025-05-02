<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalResearch = Research::count();
        $totalComments = Comment::count();
        $totalRatings = Rating::count();
        $totalPendingResearch = Research::where('status', 'Pending')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalResearch',
            'totalComments',
            'totalRatings',
            'totalPendingResearch'
        ));
    }


    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->user_id . ',user_id',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
}
