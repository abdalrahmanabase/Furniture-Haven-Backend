<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthViewController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        // Validate the form input
        $fields = $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed', // Ensures password_confirmation is provided
        ]);

        // Create new user
        $user = User::create([
            'user_name' => $fields['user_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        // Log in the new user automatically
        Auth::login($user);

        // Redirect to OverView after registration
        return redirect()->route('OverView')->with('success', 'Registration successful!');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Validate login fields
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required'
        ]);

        // Attempt login
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        // Redirect to OverView after login
        return redirect()->route('OverView')->with('success', 'Login successful!');
    }

    /**
     * Handle user logout.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
