<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Favorite::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate(
        //     [
        //         'user_id' => 'required|exists:users,id',
        //         'product_id'
        //         => 'required|exists:products,id|unique:favorites,user_id,NULL,id,product_id,' . $request->input('product_id'),
        //     ]
        // );
        // return Favorite::create($request->all());



        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $favorite = Favorite::where('user_id', $request->input('user_id'))
            ->where('product_id', $request->input('product_id'))
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Product removed from favorites.']);
        } else {
            Favorite::create($request->all());
            return response()->json(['message' => 'Product favorited successfully.']);
        }


        //used in many to many relation to save in favoriteproduct table

        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'product_id' => 'required|exists:products,id',
        // ]);

        // $userId = $request->input('user_id');
        // $productId = $request->input('product_id');

        // $favorite = Favorite::where('user_id', $userId)
        //     ->where('product_id', $productId)
        //     ->first();

        // if ($favorite) {
        //     $product = Product::findOrFail($productId);
        //     $product->favorites()->detach($favorite->id);
        //     $favorite->delete();
        //     return response()->json(['message' => 'Product removed from favorites.']);
        // } else {

        //     $product = Product::findOrFail($productId);
        //     $newFavorite = new Favorite();
        //     $newFavorite->user_id = $userId;
        //     $newFavorite->product_id = $productId;
        //     $newFavorite->save();

        //     // Save in favorite_product pivot table
        //     $product->favorites()->attach($newFavorite->id);
        //     return response()->json(['message' => 'Product favorited successfully.']);
        // }
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
    public function destroy(int $userId, int $product_id)
    {
        Favorite::destroy([$userId, $product_id]);
        return response()->json(['success' => true]);
    }
}
