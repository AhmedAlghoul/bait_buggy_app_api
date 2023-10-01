<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\User;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Block::all();
        return response()->view('admin.blocks.index', ['blocks' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return Response()->view('admin.blocks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'blocker' => 'required',
                'blocked' => 'required',
            ]
        );

        $favorite =  Block::create([
            'blocker_id' => $request->input('blocker'),
            'blocked_id' => $request->input('blocked'),
        ]);
        session()->flash('success', 'Block has been made successfully');
        return redirect()->route('block.create');
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
        $block = Block::findOrFail($id);
        $users = User::all();
        return response()->view('admin.blocks.edit', ['users' => $users, 'block' => $block]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'blocker' => 'required',
                'blocked' => 'required',
            ]
        );

        $block = Block::findOrFail($id);
        $block->blocker_id = $request->input('blocker');
        $block->blocked_id = $request->input('blocked');
        $block->save();

        session()->flash('success', 'Block has been updated successfully');
        return redirect()->route('block.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $isDestroyed = Block::destroy($id);
        return response()->json(['message' => $isDestroyed ? 'Block has been deleted successfully' : 'An error occurred while deleting the Block'], $isDestroyed ? 200 : 400);
    }
}
