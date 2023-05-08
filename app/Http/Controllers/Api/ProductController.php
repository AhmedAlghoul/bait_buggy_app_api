<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'price' => 'required',
                'description' => 'required',
                'user_id' => 'required|exists:users,id',
                'category_id' => 'required|exists:categories,id',
                'latitude' => 'nullable',
                'longitude' => 'nullable',
                'address' => 'nullable',
                // 'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // 'image' => 'required',
            ]
        );
        $product = Product::create($request->all());

        if ($request->hasFile('image')) {

            foreach ($request->file('image') as $img) {
            $file = $img;
            $image_file = $file->store('/products', [
                'disk' => 'uploads',
            ]);
            $product->images()->create([
                'image_path' => $image_file
            ]);
            }
        }
        return $product;
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
        //need to delete the related models to it
        return Product::destroy($id);
    }
}
