@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'System Reports')
 
@section('content')
<div class="container-fluid">
    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Posts</h6>
                    <h3>{{ $totalContent }}</h3>
                    <small class="text-muted">Published: {{ $publishedContent }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Users</h6>
                    <h3>{{ $totalUsers }}</h3>
                    <small class="text-muted">Active: {{ $activeUsers }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Comments</h6>
                    <h3>{{ $totalComments }}</h3>
                    <small class="text-muted">Approved: {{ $approvedComments }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Views</h6>
                    <h3>{{ $totalViews }}</h3>
                    <small class="text-muted">Avg: {{ round($averageViews, 2) }}</small>
                </div>
            </div>
        </div>
    </div>
 
    <div class="row mb-4">
        <!-- Content Status Report -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Content Status Report</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><strong>Published</strong></td>
                                    <td>{{ $publishedContent }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" style="width: {{ ($publishedContent / ($totalContent ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                                <tr>
                                    <td><strong>Drafts</strong></td>
                                    <td>{{ $draftContent }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-warning" style="width: {{ ($draftContent / ($totalContent ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                                <tr>
                                    <td><strong>Hidden</strong></td>
                                    <td>{{ $hiddenContent }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-secondary" style="width: {{ ($hiddenContent / ($totalContent ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
 
        <!-- User Status Report -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Status Report</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><strong>Active</strong></td>
                                    <td>{{ $activeUsers }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" style="width: {{ ($activeUsers / ($totalUsers ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                                <tr>
                                    <td><strong>Inactive</strong></td>
                                    <td>{{ $inactiveUsers }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-danger" style="width: {{ ($inactiveUsers / ($totalUsers ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <div class="row mb-4">
        <!-- Comment Status Report -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Comment Status Report</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><strong>Approved</strong></td>
                                    <td>{{ $approvedComments }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-success" style="width: {{ ($approvedComments / ($totalComments ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                                <tr>
                                    <td><strong>Pending</strong></td>
                                    <td>{{ $pendingComments }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-warning" style="width: {{ ($pendingComments / ($totalComments ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                                <tr>
                                    <td><strong>Spam</strong></td>
                                    <td>{{ $spamComments }}</td>
                                    <td><div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-danger" style="width: {{ ($spamComments / ($totalComments ?: 1) * 100) }}%"></div>
                                    </div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
 
        <!-- Most Viewed Posts -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Top 10 Most Viewed Posts</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPosts as $post)
                                    <tr>
                                        <td>{{ Str::limit($post->title, 30) }}</td>
                                        <td><span class="badge bg-info">{{ $post->views }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-muted">No posts</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 