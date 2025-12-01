<?php

namespace App\Http\Controllers;

use App\Models\CategoryGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryGroupWebController extends Controller
{
    public function index(Request $request): Response
    {
        $categoryGroups = CategoryGroup::where('user_id', $request->user()->id)
            ->with('categories')
            ->get();

        return Inertia::render('category-groups/Index', [
            'categoryGroups' => $categoryGroups,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('category-groups/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        CategoryGroup::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('category-groups.index')
            ->with('success', 'Category group created successfully');
    }

    public function edit(Request $request, CategoryGroup $categoryGroup): Response
    {
        if ($categoryGroup->user_id !== $request->user()->id) {
            abort(403);
        }

        return Inertia::render('category-groups/Form', [
            'categoryGroup' => $categoryGroup,
        ]);
    }

    public function update(Request $request, CategoryGroup $categoryGroup): RedirectResponse
    {
        if ($categoryGroup->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'order' => 'sometimes|required|integer|min:0',
        ]);

        $categoryGroup->update($validated);

        return redirect()->route('category-groups.index')
            ->with('success', 'Category group updated successfully');
    }

    public function destroy(Request $request, CategoryGroup $categoryGroup): RedirectResponse
    {
        if ($categoryGroup->user_id !== $request->user()->id) {
            abort(403);
        }

        $categoryGroup->delete();

        return redirect()->route('category-groups.index')
            ->with('success', 'Category group deleted successfully');
    }
}
