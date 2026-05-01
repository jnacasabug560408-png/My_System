@extends('layouts.app')
@section('title', 'My Content')
@section('page-title', 'Content Management')
 
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>My Content</h2>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'author')
    <a href="{{ route('contents.create') }}" class="btn btn-primary">
        Create New Post
    </a>
@endif
    </div>
 
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                            <tr>
                                <td>
                                    <strong>{{ Str::limit($content->title, 40) }}</strong>
                                </td>
                                <td>{{ $content->category->name ?? 'Uncategorized' }}</td>
                                <td>
                                    @if($content->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @elseif($content->status === 'draft')
                                        <span class="badge bg-warning">Draft</span>
                                    @else
                                        <span class="badge bg-secondary">Hidden</span>
                                    @endif
                                </td>
                                <td><i class="bi bi-eye"></i> {{ $content->views }}</td>
                                <td>{{ $content->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('contents.show', $content) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(Auth::user()->can('update', $content))
                                    <a href="{{ route('contents.edit', $content) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endif
                                    @if(Auth::user()->can('delete', $content))
                                    <form action="{{ route('contents.destroy', $content) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this content?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted">No content found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $contents->links() }}
        </div>
    </div>
</div>
@endsection