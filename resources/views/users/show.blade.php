@extends('layouts.app')
@section('title', $user->name)
@section('page-title', 'User Profile: ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Username:</strong> {{ $user->username }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Full Name:</strong> {{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Role:</strong> <span class="badge bg-primary">{{ ucfirst($user->role) }}</span></p>
                            <p><strong>Status:</strong> @if($user->is_active) <span class="badge bg-success">Active</span> @else <span class="badge bg-danger">Inactive</span> @endif</p>
                            <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted">Content Created</h6>
                            <h3>{{ $user->contents->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted">Comments Posted</h6>
                            <h3>{{ $user->comments->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted">Media Uploaded</h6>
                            <h3>{{ $user->media->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Content -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Content</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->contents()->latest()->limit(5)->get() as $content)
                                    <tr>
                                        <td><a href="{{ route('contents.show', $content) }}">{{ Str::limit($content->title, 50) }}</a></td>
                                        <td><span class="badge bg-{{ $content->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($content->status) }}</span></td>
                                        <td>{{ $content->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No content</td></tr>
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