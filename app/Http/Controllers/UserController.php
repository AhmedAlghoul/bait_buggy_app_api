<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        // dd($data);
        return response()->view('admin.users.index', ['users' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'photo_url' => 'required',
                'user_name' => 'required',
                'user_email' => 'required|email',
                'phone_number' => 'required',
                'password' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'address' => 'required',
                'user_type' => 'required',
            ]
        );
        if ($request->hasFile('photo_url')) {

            $file = $request->file('photo_url');

            $image_file = $file->store('/', ['disk' => 'uploads']);
            $request->merge([
                'photo' => $image_file,
            ]);
        }

        $user =  User::create([
            'photo' => $request->input('photo'),
            'user_name' => $request->input('user_name'),
            'email' => $request->input('user_email'),
            'phone_number' => $request->input('phone_number'),
            'password' => $request->input('password'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'address' => $request->input('address'),
            'user_type' => $request->input('user_type'),

        ]);
        session()->flash('success', 'User has been added successfully');
        return redirect()->route('user.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return response()->view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                // 'photo_url' => 'required',
                'user_name' => 'required',
                'user_email' => 'required|email',
                'phone_number' => 'required',
                'password' => 'nullable',
                'latitude' => 'required',
                'longitude' => 'required',
                'address' => 'required',
                'user_type' => 'required',
            ]
        );
        $user = User::findOrFail($id);

        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $image_file = $file->store('/', ['disk' => 'uploads']);
            $user->photo = $image_file;
        }

        $user->user_name = $request->input('user_name');
        $user->email = $request->input('user_email');
        $user->phone_number = $request->input('phone_number');
        if ($request->filled('password')) {
            $user->password = $request->input('password');
        }
        $user->latitude = $request->input('latitude');
        $user->longitude = $request->input('longitude');
        $user->address = $request->input('address');
        $user->user_type = $request->input('user_type');

        $user->save(); // Save the updated user

        session()->flash('success', 'User has been updated successfully');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDestroyed = User::destroy($id);
        return response()->json();
    }
}
