<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'title' => 'nullable',
            'price' => 'nullable',
            'description' => 'nullable',
            'user_id' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'address' => 'nullable',
            // 'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'image' => 'required',
        ]);

        $product->fill($request->all());
        $product->save();

        if ($request->hasFile('image')) {
            // || ($request->hasFile('image') && $request->input('image') === null)
            //Delete previous saved images
            foreach ($product->images as $image) {
                if (Storage::disk('uploads')->exists($image->image_path)) {
                    Storage::disk('uploads')->delete($image->image_path); // delete the file from the disk
                }
                $image->delete(); // delete the image record from the database
            }

            // Upload and save new images
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        foreach ($product->images as $image) {
            Storage::disk('uploads')->delete($image->image_path); // delete the file from the disk
            $image->delete(); // delete the image record from the database
        }
        // Delete the product from the products table
        $product->delete();
        // Return a success message
        return response()->json(['message' => 'Product and related images deleted successfully']);
    }

    public function search(string $title)
    {
        return Product::where('title', 'like', '%' . $title . '%')->get();
    }
}
