@extends('layouts.app')
@section('title', 'Content Moderation')
@section('page-title', 'Content Moderation')
 
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Content</h5>
                </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                            <tr>
                                <td>{{ Str::limit($content->title, 50) }}</td>
                                <td>{{ $content->user->name }}</td>
                                <td>
                                    <form action="{{ route('contents.updateStatus', $content) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="draft" @selected($content->status === 'draft')>Draft</option>
                                            <option value="published" @selected($content->status === 'published')>Published</option>
                                            <option value="hidden" @selected($content->status === 'hidden')>Hidden</option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $content->views }}</td>
                                <td>{{ $content->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('contents.show', $content) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
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