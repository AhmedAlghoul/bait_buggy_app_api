<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();
        return response()->view('admin.products.index', ['products' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return response()->view('admin.products.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'title' => 'required',
                'price' => 'required',
                'description' => 'required',
                'user' => 'required',
                'category' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]
        );

        $user =  Product::create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'user_id' => $request->input('user'),
            'category_id' => $request->input('category'),
            'address' => $request->input('address'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),

        ]);
        session()->flash('success', 'Product has been added successfully');
        return redirect()->route('product.create');
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
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $users = User::all();
        return response()->view('admin.products.edit', ['product' => $product, 'categories' => $categories, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'user' => 'required',
            'category' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->user_id = $request->input('user');
        $product->category_id = $request->input('category');
        $product->address = $request->input('address');
        $product->latitude = $request->input('latitude');
        $product->longitude = $request->input('longitude');
        $product->save();

        session()->flash('success', 'Product has been updated successfully');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDestroyed = Product::destroy($id);
        return response()->json(['message' => $isDestroyed ? 'Product has been deleted successfully' : 'An error occurred while deleting the product'], $isDestroyed ? 200 : 400);
    }
}
