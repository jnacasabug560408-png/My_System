@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        {{-- Inadjust ang width sa col-md-5 para mas compact at "centered" tingnan --}}
        <div class="col-md-5">
            
            <div class="card shadow border-0 rounded-4">
                {{-- Card Header na may Gradient or Subtle Gray --}}
                <div class="card-header bg-light border-0 py-3 px-4 rounded-top-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                            <i class="bi bi-folder-plus fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Category Management</h5>
                            <small class="text-muted">Create or assign categories</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        
                        {{-- New Category Name --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold text-secondary">New Category Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-pencil"></i></span>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                       placeholder="Enter category name..." 
                                       value="{{ old('name') }}" 
                                       required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Category Dropdown Option (Para makita ang existing) --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">View Existing Categories</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-list-ul"></i></span>
                                <select class="form-select border-start-0 ps-0" id="existing_categories">
                                    <option selected disabled>Choose from existing...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                                Back
                            </a>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 shadow-sm">
                                <i class="bi bi-save me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Dashboard Link sa baba --}}
            <div class="text-center mt-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-speedometer2 me-1"></i> Return to Dashboard
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    /* Custom Adjustments */
    .card {
        background-color: #ffffff;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    .input-group-text {
        color: #6c757d;
        border-right: none;
    }
    /* Simple Hover para sa buttons */
    .btn-primary:hover {
        transform: translateY(-1px);
        transition: 0.2s;
    }
</style>
@endsection