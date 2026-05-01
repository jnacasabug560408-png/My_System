@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    @if(Auth::user()->isAdmin())
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-total-users">
                    <div class="card-body text-white">
                        <h6>Total Users</h6>
                        <h3>{{ $totalUsers ?? 0 }}</h3>
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-total-posts">
                    <div class="card-body text-white">
                        <h6>Total Posts</h6>
                        <h3>{{ $totalContent ?? 0 }}</h3>
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-total-comments">
                    <div class="card-body text-white">
                        <h6>Total Comments</h6>
                        <h3>{{ $totalComments ?? 0 }}</h3>
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-pending-comments">
                    <div class="card-body text-white">
                        <h6>Pending Comments</h6>
                        <h3>{{ $pendingComments ?? 0 }}</h3>
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">Recent Posts</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentContent ?? [] as $content)
                                <tr>
                                    <td class="fw-medium">{{ Str::limit($content->title, 50) }}</td>
                                    <td>{{ $content->user->name }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-{{ $content->status === 'published' ? 'success' : 'warning' }}">
                                            {{ ucfirst($content->status) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $content->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No posts yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-total-users">
                    <div class="card-body text-white">
                        <h6>My Posts</h6>
                        <h3>{{ $myContent ?? 0 }}</h3>
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-total-posts">
                    <div class="card-body text-white">
                        <h6>Drafts</h6>
                        <h3>{{ $myDrafts ?? 0 }}</h3>
                        <i class="bi bi-archive"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-pending-comments">
                    <div class="card-body text-white">
                        <h6>Published</h6>
                        <h3>{{ $myPublished ?? 0 }}</h3>
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card card-total-comments">
                    <div class="card-body text-white">
                        <h6>My Comments</h6>
                        <h3>{{ $myComments ?? 0 }}</h3>
                        <i class="bi bi-chat-dots"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif
</div>

<style>
:root {
    /* Updated Palette from your request */
    --card-blue: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
    --card-cyan: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    --card-rose: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
    --card-emerald: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stat-card {
    border: none;
    border-radius: 16px; /* Matches modern aesthetic */
    padding: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.card-total-users { background: var(--card-blue) !important; }
.card-total-posts { background: var(--card-cyan) !important; }
.card-total-comments { background: var(--card-rose) !important; }
.card-pending-comments { background: var(--card-emerald) !important; }

.stat-card h6 {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    opacity: 0.8;
}

.stat-card h3 {
    font-size: 2rem;
    font-weight: 700;
}

.stat-card i {
    position: absolute;
    right: 20px;
    bottom: 15px;
    font-size: 2.5rem;
    opacity: 0.2; /* Subtle icon look */
}
</style>
@endsection