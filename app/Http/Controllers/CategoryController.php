<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{

    /**
     * ADMIN ONLY - List Categories
     */
    public function index()
    {
        Gate::authorize('admin');
        
        // Kinukuha ang categories kasama ang bilang ng posts/contents nito
        $categories = Category::withCount('contents')->paginate(10);
        
        return view('categories.index', compact('categories'));
    }

    /**
     * ADMIN ONLY - Create View
     */
    public function create()
    {
        $categories = Category::all(); 
    return view('categories.create', compact('categories'));
    }
    
    /**
     * ADMIN ONLY - Save New Category
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => 'required|string|unique:categories|max:100',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'New category added successfully!');
    }

    /**
     * PUBLIC/CREATOR - Para sa Dropdown ng "Create Post"
     * Ito ang gagamitin ni Daryl Joy para makapili ng category
     */
    public function list()
    {
        // Walang Gate::authorize dito para kahit Creator ay makakuha ng listahan
        return Category::select('id', 'name')->orderBy('name')->get();
    }

    /**
     * ADMIN ONLY - Edit View
     */
    public function edit(Category $category)
    {
        Gate::authorize('admin');
        return view('categories.edit', compact('category'));
    }

    /**
     * ADMIN ONLY - Update Category
     */
    public function update(Request $request, Category $category)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:100',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function show(Category $category) // Dapat 'Category' model ang gamit
{
    $contents = $category->contents()->where('status', 'published')->paginate(10);
    $categories = Category::all();
    $tags = \App\Models\Tag::all();
    
    return view('contents.public-index', compact('contents', 'categories', 'tags', 'category'));
}
    /**
     * ADMIN ONLY - Delete
     */
    public function destroy(Category $category)
    {
        Gate::authorize('admin');

        // Security Check: Huwag i-delete kung may laman na posts
        if ($category->contents()->count() > 0) {
            return back()->with('error', 'Action denied: This category still has posts linked to it.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}