<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LostFound;
use App\Models\Category;

class LostFoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $lostItems = LostFound::with('category')
            ->latest()
            ->paginate(12);

        $cat = new Category();
        $categories = $cat->active()->get();

        return view('welcome', [
            'lostItems' => $lostItems,
            'categories' => $categories
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lostItems = LostFound::with('category')
            ->latest()
            ->paginate(12);

        $cat = new Category();
        $categories = $cat->active()->get();

        return view('frontend.lost-items', [
            'lostItems' => $lostItems,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.lost-report', [
            'categories' => Category::where('active', true)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'found_location' => 'nullable|string|max:255',
            'found_date' => 'nullable|date',
            'founder_name' => 'required|string|max:255',
            'founder_email' => 'nullable|email|max:255',
            'founder_phone' => 'required|string|max:20',
            'founder_address' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator) {
            return response()->json([
                'errors' => $validator,
                'message' => __('lang_v1.verification_failed')
            ], 422);
        }

        try {
            $data = $validator;

            // Handle file uploads
            $data['image'] = $this->uploadImage($request->file('image'), '');
            if ($request->hasFile('image2')) {
                $data['image2'] = $this->uploadImage($request->file('image2'), '');
            }
            if ($request->hasFile('image3')) {
                $data['image3'] = $this->uploadImage($request->file('image3'), '');
            }

            $data['status'] = 'pending';

            $lostFound = LostFound::create($data);

            return response()->json([
                'message' => __('lang_v1.item_successfully_reported'),
                'data' => $lostFound
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('lang_v1.process_failed'),
            ], 500);
        }
    }

    private function uploadImage($file, $folder)
    {
        if (!$file) return null;

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs("public/{$folder}", $fileName);

        return "storage/{$folder}/{$fileName}";
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $item = LostFound::with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.lost-item-details', ['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('frontend.edit-lost-item', ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Logic to update lost item
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Logic to delete lost item
    }
}
