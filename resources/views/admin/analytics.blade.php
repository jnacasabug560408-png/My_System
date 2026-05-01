@extends('layouts.app')
@section('title', 'Analytics')
@section('page-title', 'System Analytics')
 
@section('content')
<div class="container-fluid">
    <!-- Content Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Published Posts</h6>
                    @php $published = $contentStats->where('status', 'published')->first(); @endphp
                    <h3>{{ $published->total ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Draft Posts</h6>
                    @php $draft = $contentStats->where('status', 'draft')->first(); @endphp
                    <h3>{{ $draft->total ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Hidden Posts</h6>
                    @php $hidden = $contentStats->where('status', 'hidden')->first(); @endphp
                    <h3>{{ $hidden->total ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Comments</h6>
                    @php $totalComments = $commentStats->sum('total'); @endphp
                    <h3>{{ $totalComments }}</h3>
                </div>
            </div>
        </div>
    </div>
 
    <div class="row mb-4">
        <!-- User Role Distribution -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Users by Role</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userStats as $stat)
                                    <tr>
                                        <td><strong>{{ ucfirst($stat->role) }}</strong></td>
                                        <td><span class="badge bg-primary">{{ $stat->total }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-muted">No users</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
 
        <!-- Comment Status Distribution -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Comments by Status</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commentStats as $stat)
                                    <tr>
                                        <td><strong>{{ ucfirst($stat->status) }}</strong></td>
                                        <td>
                                            <span class="badge 
                                                @if($stat->status === 'approved') bg-success
                                                @elseif($stat->status === 'pending') bg-warning
                                                @elseif($stat->status === 'spam') bg-danger
                                                @else bg-secondary @endif">
                                                {{ $stat->total }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-muted">No comments</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <!-- Top Authors -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Top Authors</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th>Posts</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topAuthors as $author)
                            <tr>
                                <td><strong>{{ $author->name }}</strong></td>
                                <td><span class="badge bg-primary">{{ $author->contents_count }}</span></td>
                                <td><span class="badge bg-secondary">{{ ucfirst($author->role) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-muted">No authors</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection