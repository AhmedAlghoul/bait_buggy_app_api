<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Block::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate(
        //     [
        //         'blocker_id' => 'required|exists:users,id',
        //         'blocked_id' => 'required|exists:users,id',
        //     ]
        // );
        // return Block::create($request->all());

        $request->validate([
            'blocker_id' => 'required|exists:users,id',
            'blocked_id' => 'required|exists:users,id',
        ]);

        $blockerId = $request->input('blocker_id');
        $blockedId = $request->input('blocked_id');

        // Check if the block already exists
        $existingBlock = Block::where('blocker_id', $blockerId)
            ->where('blocked_id', $blockedId)
            ->first();

        if ($existingBlock) {
            // Remove the existing block
            $existingBlock->delete();
            return response()->json(['message' => 'Block removed successfully']);
        }

        // Create a new block
        $block = Block::create([
            'blocker_id' => $blockerId,
            'blocked_id' => $blockedId,
        ]);

        return $block;
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
        // return Block::destroy($id);

        $deleted = Block::destroy($id);
        return $deleted ? 'Block deleted successfully.' : 'Failed to delete Block.';
    }
}
