<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = Category::with('group')->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_group_id' => 'required|exists:category_groups,id',
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $category = Category::create($validated);

        return response()->json($category->load('group'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category->load('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'category_group_id' => 'sometimes|required|exists:category_groups,id',
            'name' => 'sometimes|required|string|max:255',
            'order' => 'sometimes|required|integer|min:0',
        ]);

        $category->update($validated);

        return response()->json($category->load('group'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
