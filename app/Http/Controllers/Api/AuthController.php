<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) // Add Request $request parameter
    {
        // Validate the request using $request->validate()
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
        ], 201); // 201 status code for successful creation
    }

    public function login(Request $request) // Add Request $request parameter
    {
        // Validate the request using $request->validate()
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Find the user
        $user = User::where('email', $fields['email'])->first();

        // Check credentials
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401); // 401 status code for unauthorized
        }

        // Generate a token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return the response
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request) // Add Request $request parameter
    {
        // Revoke all tokens for the authenticated user
        $request->user()->tokens()->delete();

        // Return the response
        return response()->json(['message' => 'Logged out successfully']);
    }
}
