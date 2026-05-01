@extends('layouts.app')
@section('title', 'Tags')
@section('page-title', 'Manage Tags')
 
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Tags</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('tags.create') }}" class="btn btn-primary">Add Tag</a>
                <i class="bi bi-tag-fill"></i> Add Tag
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tags as $tag)
                            <tr>
                                <td><strong>{{ $tag->name }}</strong></td>
                                <td><code>{{ $tag->slug }}</code></td>
                                <td><span class="badge bg-primary">{{ $tag->contents_count }}</span></td>
                                <td>
                                    <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this tag?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No tags found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $tags->links() }}
        </div>
    </div>
</div>
@endsection
 