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

    public function editprofile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'user_name' => 'required|string|max:255|unique:users,user_name,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'latitude' => ['nullable', 'numeric', 'regex:/^-?\d{1,10}(\.\d{1,8})?$/'],
            'longitude' => ['nullable', 'numeric', 'regex:/^-?\d{1,11}(\.\d{1,8})?$/'],
        ]);

        if ($request->hasFile('photo')) {
            // Process and store the uploaded photo
            $photoPath = $request->file('photo')->store('/profilephoto', [
                    'disk' => 'uploads',
                ]);
            // Update the user's photo field
            $user->photo = $photoPath;
        }

        // Update other profile fields
        $user->user_name = $request->input('user_name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->latitude = $request->input('latitude');
        $user->longitude = $request->input('longitude');
        $user->save();

        return response()->json(['message' => 'Profile updated successfully.']);
    }


    public function changepassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect.'], 401);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.']);
    }

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
