@extends('layouts.app')
@section('title', 'Edit Post')
@section('page-title', 'Edit Post')
 
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Post</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('contents.update', $content) }}" method="POST">
                        @csrf @method('PUT')
 
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $content->title) }}" required>
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label fw-bold">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $content->category_id) == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
 
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="draft" @selected(old('status', $content->status) === 'draft')>Draft</option>
                                    <option value="published" @selected(old('status', $content->status) === 'published')>Published</option>
                                    <option value="hidden" @selected(old('status', $content->status) === 'hidden')>Hidden</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
 
                        <div class="mb-3">
                            <label for="body" class="form-label fw-bold">Content</label>
                            <textarea class="form-control @error('body') is-invalid @enderror"
                                      id="body" name="body" rows="10" required>{{ old('body', $content->body) }}</textarea>
                            @error('body') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
 
                        <div class="mb-3">
                            <label for="tags" class="form-label fw-bold">Tags</label>
                            <select class="form-select @error('tags') is-invalid @enderror"
                                    id="tags" name="tags[]" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tags', $content->tags->pluck('id')->toArray()) ?? []))>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @error('tags') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
 
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Post
                        </button>
                        <a href="{{ route('contents.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 