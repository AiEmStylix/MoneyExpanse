<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryWebController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = Category::with('group')
            ->whereHas('group', function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            })
            ->get();

        return Inertia::render('categories/Index', [
            'categories' => $categories,
        ]);
    }

    public function create(Request $request): Response
    {
        $categoryGroups = CategoryGroup::where('user_id', $request->user()->id)->get();

        return Inertia::render('categories/Form', [
            'categoryGroups' => $categoryGroups,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_group_id' => 'required|exists:category_groups,id',
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(Request $request, Category $category): Response
    {
        // Ensure category belongs to user's category group
        if ($category->group->user_id !== $request->user()->id) {
            abort(403);
        }

        $categoryGroups = CategoryGroup::where('user_id', $request->user()->id)->get();

        return Inertia::render('categories/Form', [
            'category' => $category,
            'categoryGroups' => $categoryGroups,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        // Ensure category belongs to user's category group
        if ($category->group->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'category_group_id' => 'sometimes|required|exists:category_groups,id',
            'name' => 'sometimes|required|string|max:255',
            'order' => 'sometimes|required|integer|min:0',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        // Ensure category belongs to user's category group
        if ($category->group->user_id !== $request->user()->id) {
            abort(403);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
