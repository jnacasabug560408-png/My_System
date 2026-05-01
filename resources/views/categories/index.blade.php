@extends('layouts.app')
@section('title', 'Categories')
@section('page-title', 'Manage Categories')
 
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Categories</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
            </a>
        </div>
    </div>
 
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Posts</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td><span class="badge bg-primary">{{ $category->contents_count }}</span></td>
                                <td>{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}">Edit/View</a>
                                       
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No categories found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection