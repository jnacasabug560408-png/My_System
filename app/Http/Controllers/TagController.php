<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate; // Idagdag ito bestie!

class TagController extends Controller
{
    public function index()
    {
        // Mas safe gamitin ang Gate::authorize para mag-match sa AppServiceProvider natin
        Gate::authorize('admin'); 
        
        $tags = Tag::withCount('contents')->paginate(15);
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        Gate::authorize('admin');
        
        // SIGURADUHIN: Na may file ka sa resources/views/tags/create.blade.php
        return view('tags.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => 'required|string|unique:tags|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        Tag::create($validated);

        return redirect()->route('tags.index')
                        ->with('success', 'Tag created successfully!');
    }

    public function show(Tag $tag)
{
    $contents = $tag->contents()
                    ->where('status', 'published')
                    ->latest()
                    ->paginate(12);

    $categories = \App\Models\Category::withCount('contents')->get();
    $tags = Tag::withCount('contents')->get();

   return view('contents.public-index', compact('contents', 'categories', 'tags', 'tag'));
}

    public function edit(Tag $tag)
    {
        Gate::authorize('admin');
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => 'required|string|unique:tags,name,' . $tag->id . '|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $tag->update($validated);

        return redirect()->route('tags.index')
                        ->with('success', 'Tag updated successfully!');
    }

    public function destroy(Tag $tag)
    {
        Gate::authorize('admin');
        $tag->delete();
        return redirect()->route('tags.index')
                        ->with('success', 'Tag deleted successfully!');
    }
}