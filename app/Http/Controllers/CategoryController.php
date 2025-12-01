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
    public function index(Request $request): JsonResponse
    {
        $categories = Category::with('group')
            ->whereHas('group', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

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
    public function show(Request $request, Category $category): JsonResponse
    {
        // Ensure category belongs to user's category group
        if ($category->group->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($category->load('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        // Ensure category belongs to user's category group
        if ($category->group->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

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
    public function destroy(Request $request, Category $category): JsonResponse
    {
        // Ensure category belongs to user's category group
        if ($category->group->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
