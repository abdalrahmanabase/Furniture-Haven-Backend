<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'user_name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'user_name' => $fields['user_name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
        ]);

        // Generate a token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the response
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201); 
    }

    public function login(Request $request) 
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Find the user
        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401); 
        }

        // Generate a token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the response
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request) 
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
