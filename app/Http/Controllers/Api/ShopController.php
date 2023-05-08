<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Shop::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'shop_name' => 'required',
                'phone_number' => 'required',
                'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'cover' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]
        );

        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $image_file = $file->store('/', [
                'disk' => 'uploads',
            ]);
            $request->merge([
                'image_file' => $image_file,
            ]);
        }

        if ($request->hasFile('cover')) {

            $coverFile = $request->file('cover');

            $coverPath = $coverFile->store('/', [
                'disk' => 'uploads'
            ]);

            $request->merge(['cover_path' => $coverPath]);
        }

        return Shop::create([
            'image_path' => $request->input('image_path'),
            // 'title' => $request->input('title'),
            // 'description' => $request->input('description'),
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Shop::destroy($id);
    }
}
