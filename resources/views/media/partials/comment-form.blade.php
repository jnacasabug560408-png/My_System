<form action="{{ route('comments.store') }}" method="POST" class="mt-3">
    @csrf
    {{-- Content ID linkage --}}
    <input type="hidden" name="content_id" value="{{ $content->id }}">

    <div class="form-group mb-2">
        <textarea name="body" class="form-control" rows="3" placeholder="Write a comment..." required></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-sm">
        <i class="bi bi-chat-dots"></i> Post Comment
    </button>
</form>