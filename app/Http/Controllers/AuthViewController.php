<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthViewController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8'
        ]);

        // Create the user
        $user = User::create([
            'user_name' => $fields['user_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        // Optionally, you can log the user in after registration
        Auth::login($user);
        return redirect()->route('home');
    }

    public function showRegistrationForm()
    {
        return view('auth.register'); // Your login form view
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Your login form view
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ['message' => 'Invalid credentials'];
        }

        // Log the user in
        Auth::login($user);

        // Redirect to the homepage or any other page after login
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/'); 
    }
    
}
