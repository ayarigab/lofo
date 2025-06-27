<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LostFound;
use App\Models\Category;

class LostFoundApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lostItems = LostFound::with('category')
            ->latest()
            ->paginate(100);

        $cat = new Category();
        $categories = $cat->active()->get();

        return response()->json([
            'lostItems' => $lostItems,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'found_location' => 'nullable|string|max:255',
            'found_date' => 'nullable|date',
            'founder_name' => 'required|string|max:255',
            'founder_email' => 'nullable|email|max:255',
            'founder_phone' => 'required|string|max:20',
            'founder_address' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $item = LostFound::create($validated);

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return LostFound::with('category')->findOrFail($id);
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
        //
    }
}
