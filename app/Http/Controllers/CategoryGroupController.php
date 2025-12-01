<?php

namespace App\Http\Controllers;

use App\Models\CategoryGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $categoryGroups = CategoryGroup::where('user_id', $request->user()->id)
            ->with('categories')
            ->get();

        return response()->json($categoryGroups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $categoryGroup = CategoryGroup::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return response()->json($categoryGroup->load('categories'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, CategoryGroup $categoryGroup): JsonResponse
    {
        if ($categoryGroup->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($categoryGroup->load('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryGroup $categoryGroup): JsonResponse
    {
        if ($categoryGroup->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'order' => 'sometimes|required|integer|min:0',
        ]);

        $categoryGroup->update($validated);

        return response()->json($categoryGroup->load('categories'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, CategoryGroup $categoryGroup): JsonResponse
    {
        if ($categoryGroup->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $categoryGroup->delete();

        return response()->json(['message' => 'Category group deleted successfully']);
    }
}
