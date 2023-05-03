<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'user_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone_number' => 'required|string',
            'latitude' => ['required', 'numeric', 'regex:/^-?\d{1,10}(\.\d{1,8})?$/'],
            'longitude' => ['required', 'numeric', 'regex:/^-?\d{1,11}(\.\d{1,8})?$/'],
            'password' => 'required|string|confirmed',
            'user_type' => 'required|in:user,shop_owner'
        ]);

        $user = User::create([
            'user_name' => $fields['user_name'],
            'email' => $fields['email'],
            'phone_number' => $fields['phone_number'],
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude'],
            'password' => bcrypt($fields['password']),
            'user_type' => $fields['user_type']
        ]);

        $token = $user->createToken('myapptoken');
        $token->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //check email
        $user = User::where('email', $fields['email'])->first();
        //check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken');
        $token->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
