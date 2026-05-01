@extends('layouts.app')

@section('title', 'Comment Details')
@section('page-title', 'Comment Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Comment Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Author:</div>
                        <div class="col-sm-9">
                            {{ $comment->author_name }} 
                            <span class="text-muted">({{ $comment->author_email }})</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Post:</div>
                        <div class="col-sm-9">
                            <a href="{{ route('contents.show', $comment->post) }}" class="text-decoration-none">
                                {{ $comment->post->title }}
                            </a>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Status:</div>
                        <div class="col-sm-9">
                            @if($comment->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($comment->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($comment->status === 'spam')
                                <span class="badge bg-danger">Spam</span>
                            @else
                                <span class="badge bg-secondary text-white">Rejected</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Date Posted:</div>
                        <div class="col-sm-9 text-muted">
                            {{ $comment->created_at->format('M d, Y - h:i A') }}
                        </div>
                    </div>

                    <hr>

                    <div class="mt-4">
                        <label class="fw-bold mb-2">Comment Content:</label>
                        <div class="p-3 border rounded bg-light">
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        {{-- 1. MODERATION ACTIONS: Only for Admin/Editor --}}
                        @if(Auth::user()->isAdmin() || Auth::user()->isEditor())
                            @if($comment->status !== 'approved')
                                <form action="{{ route('comments.approve', $comment) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle"></i> Approve
                                    </button>
                                </form>
                            @endif

                            @if($comment->status !== 'spam')
                                <form action="{{ route('comments.spam', $comment) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-exclamation-circle"></i> Mark Spam
                                    </button>
                                </form>
                            @endif
                        @endif

                        {{-- 2. DELETE ACTION: Admin, Editor, OR the Owner of the comment --}}
                        @if(Auth::user()->isAdmin() || Auth::user()->isEditor() || Auth::id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('comments.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection