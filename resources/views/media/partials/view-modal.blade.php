<div class="modal fade" id="viewMedia{{ $file->id }}" tabindex="-1" aria-labelledby="viewMediaLabel{{ $file->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            
            {{-- Modal Header --}}
            <div class="modal-header bg-light border-bottom-0">
                <h6 class="modal-title fw-bold text-truncate" id="viewMediaLabel{{ $file->id }}" style="max-width: 80%;">
                    <i class="bi bi-file-earmark-info me-1"></i> {{ $file->original_name }}
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Modal Body: Media Preview --}}
            <div class="modal-body p-0 bg-dark d-flex align-items-center justify-content-center" style="min-height: 450px; overflow: hidden;">
                @if(Str::startsWith($file->mime_type, 'image/'))
                    {{-- Image Preview --}}
                    <img src="{{ asset($file->url) }}" 
                         class="img-fluid w-100" 
                         style="max-height: 80vh; object-fit: contain;"
                         onerror="this.src='https://placehold.co/800x600?text=Image+Not+Found';">
                
                @elseif(Str::startsWith($file->mime_type, 'video/'))
                    {{-- Video Preview --}}
                    <video controls class="w-100" style="max-height: 80vh; outline: none;">
                        <source src="{{ asset($file->url) }}" type="{{ $file->mime_type }}">
                        Your browser does not support the video tag.
                    </video>

                @else
                    {{-- Document / Other Files Placeholder --}}
                    <div class="text-center py-5 text-white">
                        <div class="mb-4">
                            @if(Str::contains($file->mime_type, 'pdf'))
                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 5rem;"></i>
                            @elseif(Str::contains($file->mime_type, 'word') || Str::contains($file->mime_type, 'officedocument'))
                                <i class="bi bi-file-earmark-word text-primary" style="font-size: 5rem;"></i>
                            @else
                                <i class="bi bi-file-earmark-text text-warning" style="font-size: 5rem;"></i>
                            @endif
                        </div>
                        <h5>No Preview Available</h5>
                        <p class="text-muted small">Type: {{ strtoupper(Str::afterLast($file->mime_type, '/')) }}</p>
                        <a href="{{ asset($file->url) }}" target="_blank" class="btn btn-outline-light px-4 rounded-pill mt-2">
                            <i class="bi bi-download me-1"></i> Download to View
                        </a>
                    </div>
                @endif
            </div>

            {{-- Modal Footer: File Details & Copy Link --}}
            <div class="modal-footer bg-light border-top-0">
                <div class="container-fluid p-0">
                    <div class="row align-items-center">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="d-flex flex-column">
                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> <strong>Uploaded:</strong> {{ $file->created_at->format('M d, Y h:i A') }}</small>
                                <small class="text-muted"><i class="bi bi-hdd me-1"></i> <strong>Size:</strong> {{ number_format($file->file_size / 1048576, 2) }} MB</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group input-group-sm shadow-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" class="form-control border-start-0" value="{{ url($file->url) }}" readonly id="urlInput{{ $file->id }}">
                                <button class="btn btn-primary px-3" type="button" onclick="copyMediaUrl('{{ $file->id }}', this)">
                                    <i class="bi bi-clipboard me-1"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Copy Script (Safe to include multiple times inside @foreach) --}}
<script>
    if (typeof copyMediaUrl !== 'function') {
        function copyMediaUrl(id, btn) {
            const copyText = document.getElementById("urlInput" + id);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            
            // Visual Feedback
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
            btn.classList.replace('btn-primary', 'btn-success');
            
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.replace('btn-success', 'btn-primary');
            }, 2000);
        }
    }
</script>