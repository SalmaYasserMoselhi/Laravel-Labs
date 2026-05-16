<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // POST /api/register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->forceFill(['password' => $validated['password']])->save();

        return response()->json([
            'message' => 'User registered successfully',
            'status' => 'success',
        ], 201);
    }

    // POST /api/login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('auth_token')->plainTextToken; // createToken returns newAccessToken obj

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'status' => 'success',
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized, invalid credentials',
            'status' => 'failed',
        ], 401);
    }

    // POST /api/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 'success',
        ], 200);
    }
}
