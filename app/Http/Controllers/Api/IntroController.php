<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Intro;
use Illuminate\Http\Request;

class IntroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Intro::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'title' => 'required',
                'description' => 'required',
            ]
        );
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $image_file = $file->store('/', [
                'disk' => 'uploads',
            ]);
            $request->merge([
                'image_path' => $image_file,
            ]);
        }

        return Intro::create([
            'image_path' => $request->input('image_path'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $intro = Intro::findOrFail($id);
        $request->validate(
            [
                'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'title' => 'required',
                'description' => 'required',
            ]
        );

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $image_file = $file->store('/', [
                'disk' => 'uploads',
            ]);
            $intro->image_path = $image_file;
        }

        $intro->title = $request->input('title');
        $intro->description = $request->input('description');
        $intro->save();

        return $intro;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Intro::destroy($id);
    }
}
