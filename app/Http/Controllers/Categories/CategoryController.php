<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orWhere('is_system', true)
            ->orderBy('created_at', 'asc')
            ->get();
        // $categories = Category::All();

        return Inertia::render('categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('categories/CreateCategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Category::create([
            'name' => $validated['name'],
            'user_id' => auth()->id(),
            'is_system' => false,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Danh mục đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $request = $category->id;
        dd('request');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Authorization check
        if ($category->user_id !== auth()->id() && ! $category->is_system) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('categories/EditCategory', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if ($category->user_id !== auth()->id() && $category->is_system) {
            abort(403, 'Unauthorized');
        }

        // Validate the request
        $validated = $request->validated();

        // Update the category
        $category->update([
            'name' => $validated['name'],
            // 'is_system' should generally not be changed by users
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Ensure only owner or system admin can delete
        if ($category->user_id !== auth()->id() && ! $category->is_system) {
            abort(403, 'Unauthorized');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
