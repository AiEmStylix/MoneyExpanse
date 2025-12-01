<?php

namespace App\Http\Controllers;

use App\Models\BudgetAssignment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BudgetAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $budgetAssignments = BudgetAssignment::with('category.group')
            ->whereHas('category.group', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

        return response()->json($budgetAssignments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'month' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        $budgetAssignment = BudgetAssignment::create($validated);

        return response()->json($budgetAssignment->load('category'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, BudgetAssignment $budgetAssignment): JsonResponse
    {
        // Ensure budget assignment belongs to user's category
        if ($budgetAssignment->category->group->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($budgetAssignment->load('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BudgetAssignment $budgetAssignment): JsonResponse
    {
        // Ensure budget assignment belongs to user's category
        if ($budgetAssignment->category->group->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'month' => 'sometimes|required|date',
            'amount' => 'sometimes|required|numeric|min:0',
        ]);

        $budgetAssignment->update($validated);

        return response()->json($budgetAssignment->load('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BudgetAssignment $budgetAssignment): JsonResponse
    {
        // Ensure budget assignment belongs to user's category
        if ($budgetAssignment->category->group->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $budgetAssignment->delete();

        return response()->json(['message' => 'Budget assignment deleted successfully']);
    }
}
