<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Item::orderBy('created_at', 'DESC')->get(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item.name' => 'required|string|max:255',
        ]);

        $existingItem = Item::where('name', $request->item['name'])->first();

        if ($existingItem) {
            return response()->json(['message' => 'Item with this name already exists'], Response::HTTP_CONFLICT);
        }

        $newItem = new Item;
        $newItem->name = $request->item['name'];
        $newItem->save();

        return response()->json($newItem, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'item.completed' => 'required|boolean',
        ]);

        $existingItem = Item::find($id);

        if (!$existingItem) {
            return response()->json(['message' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        $existingItem->completed = $request->item['completed'];
        $existingItem->completed_at = $request->item['completed'] ? Carbon::now() : null;
        $existingItem->save();

        return response()->json($existingItem, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $existingItem = Item::find($id);

        if (!$existingItem) {
            return response()->json(['message' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        $existingItem->delete();

        return response()->json(['message' => 'Item successfully deleted'], Response::HTTP_OK);
    }
}
