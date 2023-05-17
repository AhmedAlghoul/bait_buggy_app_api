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
                'logo_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'cover_photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]
        );

        if ($request->hasFile('logo_photo')) {

            $file = $request->file('logo_photo');

            $image_file = $file->store('/', [
                'disk' => 'uploads',
            ]);
            $request->merge([
                'logo_photo' => $image_file,
            ]);
        }

        if ($request->hasFile('cover_photo')) {

            $coverFile = $request->file('cover_photo');

            $coverPath = $coverFile->store('/', [
                'disk' => 'uploads'
            ]);

            $request->merge(['cover_photo' => $coverPath]);
        }

        return Shop::create($request->all());

        // return Shop::create([
        //     'logo_photo' => $request->input('logo_photo'),
        //     'cover_photo' => $request->input('cover_photo'),
        //     // 'title' => $request->input('title'),
        //     // 'description' => $request->input('description'),
        // ]);
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
