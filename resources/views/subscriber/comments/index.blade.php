@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-chat-left-text-fill me-2"></i> My Comment History</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Post Title</th>
                        <th>Your Comment</th>
                        <th>Status</th>
                        <th>Date Posted</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td class="ps-4">
                                @if($comment->post || $comment->content)
                                    {{-- GINAGAWA NATING CLICKABLE ANG TITLE --}}
                                    <a href="{{ route('comments.show', $comment->id) }}" class="text-decoration-none fw-bold text-primary">
                                        {{ Str::limit($comment->post->title ?? $comment->content->title, 40) }}
                                    </a>
                                @else
                                    <span class="text-muted small">Post deleted</span>
                                @endif
                            </td>
                            <td><span class="text-secondary">"{{ $comment->content ?? $comment->body }}"</span></td>
                            <td>
                                @php $status = strtolower($comment->status); @endphp
                                <span class="badge rounded-pill px-3 {{ $status === 'approved' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}">
                                    {{ $status === 'approved' ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $comment->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-danger"><i class="bi bi-trash3"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">No comments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection