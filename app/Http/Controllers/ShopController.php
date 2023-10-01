<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Shop::all();
        return response()->view('admin.shops.index', ['shops' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admin.shops.create');
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
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'logo_photo_url' => 'required',
                'cover_photo_url' => 'required',

            ]
        );
        if ($request->hasFile('logo_photo_url')) {

            $file = $request->file('logo_photo_url');

            $image_file = $file->store('/', ['disk' => 'uploads']);

            $request->merge([
                'logo_photo' => $image_file,
            ]);
        }

        if ($request->hasFile('cover_photo_url')) {

            $file = $request->file('cover_photo_url');

            $image_file = $file->store('/', ['disk' => 'uploads']);

            $request->merge([
                'cover_photo' => $image_file,
            ]);
        }

        $shop =  Shop::create([
            'shop_name' => $request->input('shop_name'),
            'phone_number' => $request->input('phone_number'),
            'logo_photo' => $request->input('logo_photo'),
            'cover_photo' => $request->input('cover_photo'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'address' => $request->input('address'),


        ]);
        session()->flash('success', 'Shop has been added successfully');
        return redirect()->route('shop.create');
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
        return view('admin.shops.edit');
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
        $isDestroyed = Shop::destroy($id);
        return response()->json(['message' => $isDestroyed ? 'Shop has been deleted successfully' : 'An error occurred while deleting the Shop'], $isDestroyed ? 200 : 400);
    }
}
