<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthViewController extends Controller
{
    /**
     * Show the login form and store the previous page URL.
     */
    public function showLoginForm(Request $request)
    {
        session(['previous_url' => url()->previous()]); // Store previous URL
        return view('auth.login');
    }

    /**
     * Show the registration form and store the previous page URL.
     */
    public function showRegistrationForm(Request $request)
    {
        session(['previous_url' => url()->previous()]); // Store previous URL
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8'
        ]);

        // Create user
        $user = User::create([
            'user_name' => $fields['user_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        // Log in the user
        Auth::login($user);

        // Redirect to previous page or home if not found
        return redirect()->intended(session('previous_url', route('home')));
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        // Log in the user
        Auth::login($user);

        // Redirect to previous page or home if not found
        return redirect()->intended(session('previous_url', route('home')));
    }

    /**
     * Handle user logout.
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
