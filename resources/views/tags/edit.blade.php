@extends('layouts.app')
@section('title', 'Edit Tag')
@section('page-title', 'Edit Tag')
 
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Tag</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tags.update', $tag) }}" method="POST">
                        @csrf @method('PUT')
 
                        <div class="mb-3">
                            <label for="name" class="form-label">Tag Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $tag->name) }}" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
 
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Tag
                        </button>
                        <a href="{{ route('tags.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection