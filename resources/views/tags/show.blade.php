@extends('layouts.app')
@section('title', $tag->name)
@section('page-title', 'Posts Tagged: ' . $tag->name)
 
@section('content')
<div class="container-fluid">
    <div class="row">
        @forelse($contents as $content)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('posts.public.show', $content) }}" class="text-decoration-none">
                            {{ Str::limit($content->title, 50) }}
                        </a>
                    </h5>
                    <p class="card-text text-muted">{{ Str::limit($content->body, 100) }}</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted">By {{ $content->user->name }} on {{ $content->published_at->format('M d, Y') }}</small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center text-muted">No posts with this tag</p>
        </div>
        @endforelse
    </div>
 
    {{ $contents->links() }}
</div>
@endsection