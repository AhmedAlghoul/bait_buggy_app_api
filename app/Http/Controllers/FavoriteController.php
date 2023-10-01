<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Favorite::all();
        return response()->view('admin.favorites.index', ['favorites' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $users = User::all();
        return response()->view('admin.favorites.create', compact('products', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'product' => 'required',
                'user' => 'required',
            ]
        );

        $favorite =  Favorite::create([
            'product_id' => $request->input('product'),
            'user_id' => $request->input('user'),
        ]);
        session()->flash('success', 'Favorite Product has been added successfully');
        return redirect()->route('favorite.create');
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
        $favorite = Favorite::findOrFail($id);
        $products = Product::all();
        $users = User::all();
        return response()->view('admin.favorites.edit', ['favorite' => $favorite, 'products' => $products, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'product' => 'required',
                'user' => 'required',
            ]
        );

        $favorite = Favorite::findOrFail($id);
        $favorite->product_id = $request->input('product');
        $favorite->user_id = $request->input('user');
        $favorite->save();

        session()->flash('success', 'Favorite Product has been updated successfully');
        return redirect()->route('favorite.index'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDestroyed = Favorite::destroy($id);
        return response()->json(['message' => $isDestroyed ? 'Favorite has been deleted successfully' : 'An error occurred while deleting the favorite'], $isDestroyed ? 200 : 400);
    }
}
