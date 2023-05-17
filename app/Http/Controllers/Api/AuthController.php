<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return User::all();
    }

    // public function forgetpassword(Request $request)
    // {
    //     // Step 1: Validate the input
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     // Step 2: Check if the user with the provided email exists
    //     $user = User::where('email', $request->email)->first();
    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     // Step 3: Generate a unique token and save it to the user's record
    //     $token = Str::random(60); // You can use any method to generate a unique token
    //     $user->reset_password_token = $token;
    //     $user->reset_password_token_expires_at = now()->addHours(1); // Token expiration time
    //     $user->save();

    //     // Step 4: Send an email to the user with a reset password link containing the token
    //     // You can use your preferred email service or library to send the email
    //     // The email should contain a link like: https://example.com/reset-password?token=xxxxxxxx
    //     // where "xxxxxxxx" is the generated token

    //     return response()->json(['message' => 'Reset password email sent']);
    // }
    
    // public function editProfile(Request $request)
    // {
    //     // Step 1: Validate the input
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         // Add any other validation rules for profile fields
    //     ]);

    //     // Step 2: Get the authenticated user
    //     $user = auth()->user();

    //     // Step 3: Update the user's profile
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     // Update any other profile fields as needed
    //     $user->save();

    //     // Step 4: Return a response
    //     return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    // }

    // public function resetPassword(Request $request)
    // {
    //     // Step 1: Validate the input
    //     $request->validate([
    //         'email' => 'required|email',
    //         'token' => 'required',
    //         'password' => 'required|min:8|confirmed',
    //     ]);

    //     // Step 2: Find the user with the provided email and valid token
    //     $user = User::where('email', $request->email)
    //         ->where('reset_password_token', $request->token)
    //         ->where('reset_password_token_expires_at', '>=', now())
    //         ->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'Invalid token or expired'], 400);
    //     }

    //     // Step 3: Update the user's password
    //     $user->password = bcrypt($request->password);
    //     $user->reset_password_token = null;
    //     $user->reset_password_token_expires_at = null;
    //     $user->save();

    //     // Step 4: Return a response
    //     return response()->json(['message' => 'Password reset successfully']);
    // }

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
