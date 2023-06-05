<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return response()->view('admin.categories.index', ['categories' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'category_name' => 'required',
                'is_active' => 'in:on',
            ],
            [
                'category_name.required' => 'Category Name is required',
            ]
        );
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->is_active = $request->has('is_active') ? true : false;
        $category->save();
        session()->flash('success', 'Category has been added successfully');
        return redirect()->route('category.create');
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
        $category = Category::findOrFail($id);
        return response()->view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'category_name' => 'required',
                'is_active' => 'in:on',
            ],
            [
                'category_name.required' => 'Category Name is required',
            ]
        );
        $category = Category::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->is_active = $request->has('is_active') ? true : false;
        $category->save();
        session()->flash('success', 'Category has been updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDestroyed = Category::destroy($id);
        return response()->json(['message' => $isDestroyed ? 'category has been deleted successfully' : 'An error occurred while deleting the category'], $isDestroyed ? 200 : 400);
    }
}
