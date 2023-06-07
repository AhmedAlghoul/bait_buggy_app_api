<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Report::all();
        return response()->view('admin.reports.index', ['reports' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $users = User::all();

        return response()->view('admin.reports.create', compact('products', 'users'));
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
                'report' => 'required',
            ]
        );

        $user =  Report::create([
            'product_id' => $request->input('product'),
            'user_id' => $request->input('user'),
            'report_text' => $request->input('report'),
        ]);
        session()->flash('success', 'Report has been added successfully');
        return redirect()->route('report.create');
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
        $report = Report::findOrFail($id);
        $products = Product::all();
        $users = User::all();

        return response()->view('admin.reports.edit', compact('products', 'users', 'report'));
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
                'report' => 'required',
            ]
        );

        $report = Report::findOrFail($id);
        $report->product_id = $request->input('product');
        $report->user_id = $request->input('user');
        $report->report_text = $request->input('report');
        $report->save();

        session()->flash('success', 'Report has been updated successfully');
        return redirect()->route('report.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDestroyed = Report::destroy($id);
        return response()->json(['message' => $isDestroyed ? 'Report has been deleted successfully' : 'An error occurred while deleting the report'], $isDestroyed ? 200 : 400);
    }
}
