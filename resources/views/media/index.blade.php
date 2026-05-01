@extends('layouts.app')
@section('title', 'Media Gallery')
@section('page-title', 'Media Gallery')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold mb-0">Media Gallery</h2>
            <small class="text-muted">Logged in as: <span class="badge bg-info text-dark">{{ ucfirst(Auth::user()->role) }}</span></small>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-cloud-upload me-1"></i> Upload File
            </button>
        </div>
    </div>

    {{-- Gallery Grid --}}
    <div class="row">
        @forelse($media as $file)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                    <div class="card-body text-center d-flex flex-column p-3">
                        
                        {{-- Unified Trigger for Modal View --}}
                        <div class="media-preview-trigger rounded mb-3" 
                             style="height: 160px; overflow: hidden; background: #f8f9fa; cursor: pointer;"
                             data-bs-toggle="modal" 
                             data-bs-target="#viewMedia{{ $file->id }}"
                             title="Click to view full size">
                            
                            @if(Str::startsWith($file->mime_type, 'image/'))
                                <img src="{{ Str::contains($file->url, 'storage/') ? asset($file->url) : asset('storage/' . $file->url) }}" 
                                    class="w-100 h-100" 
                                    style="object-fit: cover;" 
                                    onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=File+Not+Found';">
                            @elseif(Str::startsWith($file->mime_type, 'video/'))
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark">
                                    <i class="bi bi-play-circle-fill text-white" style="font-size: 3rem;"></i>
                                </div>
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-file-earmark-text text-secondary" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>

                        {{-- File Info --}}
                        <h6 class="card-title text-truncate mb-1" title="{{ $file->original_name }}">
                            {{ $file->original_name }}
                        </h6>
                        
                        <div class="mb-3">
                            <span class="badge bg-light text-dark border">{{ strtoupper(Str::afterLast($file->mime_type, '/')) }}</span>
                            <small class="text-muted ms-1">
                                {{ number_format($file->file_size / 1048576, 2) }} MB
                            </small>
                        </div>

                        {{-- Security-aware Delete Button --}}
                        <div class="mt-auto">
                            @if(Auth::user()->isAdmin() || Auth::id() === $file->user_id)
                                <form action="{{ route('media.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Delete this file?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-light btn-sm w-100 text-muted" disabled>
                                    <i class="bi bi-lock"></i> Locked
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Include the Modal for each file --}}
            @include('media.partials.view-modal', ['file' => $file])

        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                <p class="mt-3 text-muted fs-5">No media files found in the gallery.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $media->links() }}
    </div>
</div>

{{-- Upload Modal --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="uploadModalLabel">Upload Media Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Choose File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="file" name="file" required>
                        <div class="form-text mt-2">
                            Allowed formats: Images, Videos, PDFs (Max: 20MB)
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Start Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection