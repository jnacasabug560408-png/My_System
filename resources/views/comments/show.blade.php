@extends('layouts.app')
@section('title', 'Comment Details')
@section('page-title', 'Comment Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2 text-primary"></i>Comment Details</h5>
                </div>
                <div class="card-body p-4">
                    {{-- Ginamit ko ang relationship: $comment->user para sa logged-in subscribers --}}
                    <p><strong>Author:</strong> {{ $comment->user->name ?? $comment->author_name }} 
                        <span class="text-muted small">({{ $comment->user->email ?? $comment->author_email }})</span>
                    </p>
                    
                    {{-- Siguraduhin na ang relation sa Content model ay 'content' or 'post' --}}
                    <p><strong>Post:</strong> 
                        <a href="{{ route('posts.public.show', $comment->content->slug ?? $comment->post->slug) }}" class="text-decoration-none">
                            {{ $comment->content->title ?? $comment->post->title }}
                        </a>
                    </p>

                    <p><strong>Status:</strong> 
                        @if($comment->status === 'approved')
                            <span class="badge rounded-pill bg-success-subtle text-success border border-success">Approved</span>
                        @elseif($comment->status === 'pending')
                            <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning">Pending</span>
                        @elseif($comment->status === 'spam')
                            <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger">Spam</span>
                        @else
                            <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary">Rejected</span>
                        @endif
                    </p>
                    
                    <p><strong>Date:</strong> <span class="text-muted">{{ $comment->created_at->format('M d, Y - h:i A') }}</span></p>

                    <<div class="card mt-4 border-0 shadow-sm" style="background: #f8f9fa;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">Comment Body:</h6>
                            {{-- Sinisigurado nating may lalabas na text gamit ang ?? fallback --}}
                            <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $comment->body ?? $comment->content ?? 'No comment text found.' }}</p>
                        </div>
                    </div>


                    <div class="mt-4 pt-3 border-top d-flex gap-2 flex-wrap">
                        @if($comment->status !== 'approved')
                        <form action="{{ route('comments.approve', $comment) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                <i class="bi bi-check-circle me-1"></i> Approve
                            </button>
                        </form>
                        @endif
                        
                        @if($comment->status !== 'spam')
                        <form action="{{ route('comments.spam', $comment) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">
                                <i class="bi bi-exclamation-circle me-1"></i> Mark as Spam
                            </button>
                        </form>
                        @endif

                        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger rounded-pill px-4" onclick="return confirm('Are you sure you want to delete this comment?')">
                                <i class="bi bi-trash me-1"></i> Delete
                            </button>
                        </form>

                        <a href="{{ route('subscriber.comments') }}" class="btn btn-light border rounded-pill px-4">
                                <i class="bi bi-arrow-left me-1"></i> Back to My Comments
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection