<?php

namespace App\Http\Controllers;

use App\Models\BudgetAssignment;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BudgetAssignmentWebController extends Controller
{
    public function index(Request $request): Response
    {
        $budgetAssignments = BudgetAssignment::with('category.group')
            ->whereHas('category.group', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

        return Inertia::render('budget-assignments/Index', [
            'budgetAssignments' => $budgetAssignments,
        ]);
    }

    public function create(Request $request): Response
    {
        $categories = Category::with('group')
            ->whereHas('group', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

        return Inertia::render('budget-assignments/Form', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'month' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        BudgetAssignment::create($validated);

        return redirect()->route('budget-assignments.index')
            ->with('success', 'Budget assignment created successfully');
    }

    public function edit(Request $request, BudgetAssignment $budgetAssignment): Response
    {
        // Ensure budget assignment belongs to user's category
        if ($budgetAssignment->category->group->user_id !== $request->user()->id) {
            abort(403);
        }

        $categories = Category::with('group')
            ->whereHas('group', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

        return Inertia::render('budget-assignments/Form', [
            'budgetAssignment' => $budgetAssignment,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, BudgetAssignment $budgetAssignment): RedirectResponse
    {
        // Ensure budget assignment belongs to user's category
        if ($budgetAssignment->category->group->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'month' => 'sometimes|required|date',
            'amount' => 'sometimes|required|numeric|min:0',
        ]);

        $budgetAssignment->update($validated);

        return redirect()->route('budget-assignments.index')
            ->with('success', 'Budget assignment updated successfully');
    }

    public function destroy(Request $request, BudgetAssignment $budgetAssignment): RedirectResponse
    {
        // Ensure budget assignment belongs to user's category
        if ($budgetAssignment->category->group->user_id !== $request->user()->id) {
            abort(403);
        }

        $budgetAssignment->delete();

        return redirect()->route('budget-assignments.index')
            ->with('success', 'Budget assignment deleted successfully');
    }
}
