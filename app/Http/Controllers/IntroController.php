<?php

namespace App\Http\Controllers;

use App\Models\Intro;
use Illuminate\Http\Request;

class IntroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Intro::all();
        return response()->view('admin.intros.index', ['intros' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admin.intros.create');
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
                'title' => 'required',
                'description' => 'required',
            ]
        );
        if ($request->hasFile('photo_url')) {

            $file = $request->file('photo_url');

            $image_file = $file->store('/', ['disk' => 'uploads']);

            $request->merge([
                'photo' => $image_file,
            ]);
        }

        $intro =  Intro::create([
            'image_path' => $request->input('photo'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),

        ]);
        session()->flash('success', 'Intro has been added successfully');
        return redirect()->route('intro.create');
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
        $intro = Intro::findOrFail($id);
        return response()->view('admin.intros.edit', ['intro' => $intro]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                // 'photo_url' => 'required',
                'title' => 'required',
                'description' => 'required',

            ]
        );
        $intro = Intro::findOrFail($id);

        if ($request->hasFile('photo_url')) {
            $file = $request->file('photo_url');
            $image_file = $file->store('/', ['disk' => 'uploads']);
            $intro->image_path = $image_file;
        }

        $intro->title = $request->input('title');
        $intro->description = $request->input('description');
        $intro->save();

        session()->flash('success', 'Intro has been updated successfully');
        return redirect()->route('intro.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDestroyed = Intro::destroy($id);
        return response()->json(['message' => $isDestroyed ? 'Intro has been deleted successfully' : 'An error occurred while deleting the intro'], $isDestroyed ? 200 : 400);
    }
}
