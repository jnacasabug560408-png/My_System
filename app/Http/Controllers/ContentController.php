<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContentController extends Controller
{
    public function index()
    {
    // Ipakita ang lahat ng posts sa kahit kanino
    $contents = Content::latest()->paginate(15);
    return view('contents.index', compact('contents'));
}

    public function publicIndex()
    {
        $contents = Content::where('status', 'published')->latest()->paginate(12);
        $categories = Category::withCount('contents')->get();
        $tags = Tag::withCount('contents')->get();
        return view('contents.public-index', compact('contents', 'categories', 'tags'));
    }

    public function create()
    {
        Gate::authorize('canCreateContent');
        $categories = Category::all();
        $tags = Tag::all();
        return view('contents.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        Gate::authorize('canCreateContent');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:10',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,hidden',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = Auth::id();
        
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $content = Content::create($validated);

        if (!empty($validated['tags'])) {
            $content->tags()->attach($validated['tags']);
        }

        return redirect()->route('contents.index')->with('success', 'Content created successfully!');
    }

    // FIXED: Para mag-match sa filename mong 'show.blade.php'
    // Siguraduhin na "publicShow" ang pangalan nito
public function show(Content $content) 
{
    // Ito yung logic na in-update natin kanina para sa Category at Tags
    $content->load(['category', 'tags', 'user']);
    
    // Ito yung view na ginawa natin
    return view('contents.show', compact('content'));
}

    /**
     * EDIT METHOD
     */
    public function edit(Content $content)
    {
        // Siguraduhin na ang may-ari lang o admin ang pwedeng mag-edit
        if (Auth::id() !== $content->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        $tags = Tag::all();
        $selectedTags = $content->tags->pluck('id')->toArray();

        return view('contents.edit', compact('content', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * UPDATE METHOD
     */
    public function update(Request $request, Content $content)
    {
        if (Auth::id() !== $content->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|min:10',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,hidden',
        ]);

        // I-update ang slug kung nagbago ang title
        $validated['slug'] = Str::slug($validated['title']);

        // Set published_at kung ngayon lang na-publish
        if ($validated['status'] === 'published' && !$content->published_at) {
            $validated['published_at'] = now();
        }

        $content->update($validated);

        // I-sync ang tags (buburahin ang wala sa listahan, idadagdag ang bago)
        $content->tags()->sync($request->tags ?? []);

        return redirect()->route('contents.index')->with('success', 'Content updated successfully!');
    }

    /**
     * DESTROY METHOD
     */
    public function destroy(Content $content)
    {
        if (Auth::id() !== $content->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Tanggalin muna ang mga tags relationship bago i-delete ang post
        $content->tags()->detach();
        $content->delete();

        return redirect()->route('contents.index')->with('success', 'Content deleted successfully!');
    }

    public function moderation()
    {
        Gate::authorize('admin');
        $contents = Content::latest()->paginate(15);
        return view('contents.moderation', compact('contents'));
    }
}