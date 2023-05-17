<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Report::all();
        // $all = Report::with('users')->get();
        //         dd($all);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'report_text' => 'nullable',
            ]
        );
        return Report::create($request->all());
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
        // $request->validate(
        //     [
        //         'product_id' => 'required|exists:products,id',
        //         'user_id' => 'required|exists:users,id',
        //         'report_text' => 'nullable',
        //     ]
        // );
        // $product = Report::find($id);
        // $product->update($request->all());
        // return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Report::destroy($id);
    }
}
