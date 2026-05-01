@extends('layouts.app')

@section('title', 'All Posts')
@section('page-title', 'Latest Posts')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- MAIN CONTENT: POSTS LIST --}}
        <div class="col-lg-8">
            
            {{-- FILTER HEADER SECTION --}}
            @if(isset($category))
                <div class="alert alert-primary bg-primary text-white border-0 shadow-sm mb-4 rounded-4">
                    <h4 class="mb-0 p-2">
                        <i class="bi bi-folder2-open me-2"></i> 
                        Showing Posts in: <strong>{{ $category->name }}</strong>
                    </h4>
                </div>
            @elseif(isset($tag))
                <div class="alert alert-secondary bg-secondary text-white border-0 shadow-sm mb-4 rounded-4">
                    <h4 class="mb-0 p-2">
                        <i class="bi bi-tag me-2"></i> 
                        Posts Tagged as: <strong>#{{ $tag->name }}</strong>
                    </h4>
                </div>
            @endif

            <div class="row mb-4">
                @forelse($contents as $content)
                <div class="col-md-6 mb-4">
                    {{-- DYNAMIC CARD COLOR LOGIC --}}
                    @php
                        $catName = strtolower($content->category->name ?? '');
                        $bgClass = 'bg-white'; // Default
                        $textClass = 'text-primary';
                        
                        if(str_contains($catName, 'education')) { $bgClass = 'bg-primary-subtle'; $textClass = 'text-primary'; }
                        elseif(str_contains($catName, 'tech')) { $bgClass = 'bg-info-subtle'; $textClass = 'text-info'; }
                        elseif(str_contains($catName, 'lifestyle')) { $bgClass = 'bg-success-subtle'; $textClass = 'text-success'; }
                        elseif(str_contains($catName, 'business')) { $bgClass = 'bg-warning-subtle'; $textClass = 'text-warning'; }
                    @endphp

                    <div class="card h-100 shadow-sm border-0 rounded-4 {{ $bgClass }} custom-card">
                        <div class="card-body p-4">
                            {{-- Category Badge --}}
                            <span class="badge rounded-pill mb-3 shadow-sm {{ $textClass }}" style="background: rgba(255,255,255,0.6);">
                                {{ $content->category->name ?? 'Uncategorized' }}
                            </span>

                            <h5 class="card-title fw-bold mb-3">
                                <a href="{{ route('posts.public.show', $content->slug) }}" class="text-dark text-decoration-none hover-primary">
                                    {{ Str::limit($content->title, 50) }}
                                </a>
                            </h5>

                            <p class="card-text text-muted mb-0" style="font-size: 0.95rem; line-height: 1.6;">
                                {{ Str::limit(strip_tags($content->body), 110) }}
                            </p>
                        </div>

                        <div class="card-footer bg-transparent border-0 p-4 pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="user-info">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($content->user->name ?? 'A') }}&background=random&size=32" class="rounded-circle me-2" alt="user">
                                        <small class="text-muted fw-semibold">
                                            {{ $content->user->name ?? 'Admin' }}<br>
                                            <span style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($content->created_at)->format('M d, Y') }}</span>
                                        </small>
                                    </div>
                                </div>
                                <a href="{{ route('posts.public.show', $content->slug) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-light rounded-4">
                        <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                        <p class="mt-3 fs-5 text-muted">No posts found in this section.</p>
                        <a href="{{ route('posts.public.index') }}" class="btn btn-primary rounded-pill">View All Posts</a>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center mt-2">
                {{ $contents->links() }}
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
           <div class="card shadow-sm border-0 mb-4 rounded-4">
        <div class="card-header bg-white fw-bold py-3 border-0">
            <i class="bi bi-folder2-open me-2 text-primary"></i> Categories
        </div>
        <div class="card-body pt-0">
            <div class="d-flex flex-wrap gap-2">
                @foreach($categories as $cat)
                    @php
                        $name = strtolower($cat->name);
                        $catColor = 'bg-light text-dark'; // Default
                        
                        if(str_contains($name, 'education')) $catColor = 'bg-primary text-white shadow-sm';
                        elseif(str_contains($name, 'tech')) $catColor = 'bg-info text-white shadow-sm';
                        elseif(str_contains($name, 'lifestyle')) $catColor = 'bg-success text-white shadow-sm';
                        elseif(str_contains($name, 'business')) $catColor = 'bg-warning text-dark shadow-sm';
                    @endphp

                    <a href="{{ route('categories.show', $cat->slug) }}" class="text-decoration-none">
                        <span class="badge rounded-pill {{ (isset($category) && $category->id == $cat->id) ? 'ring-active' : '' }} {{ $catColor }} p-2 px-3 transition-all sidebar-badge">
                            {{ $cat->name }} 
                            <span class="ms-1 opacity-75">({{ $cat->contents_count ?? $cat->contents->count() }})</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

            <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white fw-bold py-3 border-0">
            <i class="bi bi-tags me-2 text-primary"></i> Popular Tags
        </div>
        <div class="card-body pt-0">
            <div class="d-flex flex-wrap gap-2">
                @foreach($tags as $t)
                    @php
                        // Random tag colors para fun!
                        $tagColors = ['bg-primary-subtle text-primary', 'bg-success-subtle text-success', 'bg-info-subtle text-info', 'bg-danger-subtle text-danger', 'bg-warning-subtle text-warning'];
                        $randomColor = $tagColors[$loop->index % count($tagColors)];
                    @endphp

                    <a href="{{ route('tags.show', $t->slug) }}" class="text-decoration-none">
                        <span class="badge rounded-3 {{ $randomColor }} border-0 p-2 px-3 tag-pill">
                            #{{ $t->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .sidebar-badge:hover {
        filter: brightness(1.1);
        transform: scale(1.05);
    }

    .tag-pill {
        transition: all 0.3s ease;
    }

    .tag-pill:hover {
        background-color: #0d6efd !important;
        color: white !important;
        transform: rotate(-2deg);
    }

    .ring-active {
        outline: 3px solid rgba(13, 110, 253, 0.2);
        border: 1px solid #0d6efd !important;
    }
    
    .custom-card {
        transition: all 0.3s ease;
    }
    .custom-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .hover-primary:hover { 
        color: #0d6efd !important; 
    }
    .transition-all {
        transition: all 0.2s ease;
    }
    .tag-hover:hover {
        background-color: #0d6efd !important;
        color: white !important;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endsection