<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Researcher;
use App\Models\GeneralUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:researcher,user',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'institution' => 'required_if:role,researcher',
            'expertise' => 'required_if:role,researcher',
        ], [
            'role.required' => 'Please select a role.',
            'role.in' => 'Invalid role selected.',
            'name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'institution.required_if' => 'Institution is required for researchers.',
            'expertise.required_if' => 'Expertise field is required for researchers.'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'role' => $request->role,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                if ($request->role === 'researcher') {
                    Researcher::create([
                        'user_id' => $user->user_id,
                        'institution' => $request->institution,
                        'expertise' => $request->expertise,
                    ]);
                } elseif ($request->role === 'user') {
                    GeneralUser::create([
                        'user_id' => $user->user_id,
                        'membership_level' => 'Free',
                        'points' => 0,
                    ]);
                }
            });
            return redirect()->route('auth.login')->with('success', 'Registration successful! You can now log in.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong, please try again.')->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate Input
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,researcher,user',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'role.required' => 'Please select a role.',
            'role.in' => 'Invalid role selected.',
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role == 'researcher') {
                return redirect()->route('researcher.dashboard');
            } elseif ($user->role == 'user') {
                return redirect()->route('user.dashboard');
            } else {
                Auth::logout();
                return back()->with('error', 'Invalid role selection.')->withInput();
            }
        }
        return back()->with('error', 'Invalid credentials.')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login')->with('success', 'Logged out successfully.');
    }
}
