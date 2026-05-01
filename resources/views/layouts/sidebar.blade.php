@php
    use Illuminate\Support\Str;

    

    // 1. Kunin ang role at gawing lowercase para safe sa kahit anong spelling (Subscriber vs subscriber)
    $userRole = Auth::check() ? Str::lower(trim(Auth::user()->role)) : '';

    // 2. Define permissions
    $isAdmin = ($userRole === 'admin');
    $isEditor = ($userRole === 'editor');
    
    // Check if subscriber (case insensitive)
    $isSubscriber = ($userRole === 'subscriber');
    
    // Management access
    $isCreatorOrHigher = in_array($userRole, ['admin', 'editor', 'author', 'creator']);
    
    // Moderation access
    $canModerate = in_array($userRole, ['admin', 'editor']);
@endphp

<aside class="sidebar shadow-sm" style="background: #1a1a2e; color: white; min-height: 100vh; width: 250px; padding: 20px;">
    <h5 class="text-center py-3 border-bottom border-secondary mb-4">CMS PANEL</h5>

    <ul class="nav flex-column">
        {{-- ALWAYS VISIBLE --}}
        <li class="nav-item mb-2">
            <a class="nav-link text-white {{ request()->is('dashboard*') ? 'opacity-100 fw-bold' : 'opacity-75' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        {{-- TEST: Lalabas ito sa lahat para ma-verify natin kung working ang route --}}
        <li class="nav-item mb-2">
            <a class="nav-link text-white {{ request()->is('my-comments*') ? 'opacity-100 fw-bold' : 'opacity-75' }}" href="{{ route('subscriber.comments') }}">
                <i class="bi bi-chat-left-text me-2 text-info"></i> My Comments
            </a>
        </li>

        {{-- MANAGEMENT SECTION --}}
        @if($isCreatorOrHigher)
            <div class="small text-uppercase text-secondary mt-3 mb-2" style="font-size: 0.7rem;">Management</div>
            
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('contents.index') }}">
                    <i class="bi bi-file-earmark-text me-2"></i> My Posts
                </a>
            </li>
            
           @if(strtolower(auth()->user()->role) === 'admin' || strtolower(auth()->user()->role) === 'author')
    <li class="nav-item mb-2">
        <a class="nav-link text-white" href="{{ route('contents.create') }}">
            <i class="bi bi-pencil-square me-2"></i> Create Post
        </a>
    </li>
@endif

            @if($canModerate)
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('comments.index') }}">
                        <i class="bi bi-chat-dots me-2 text-warning"></i> Moderate Comments
                    </a>
                </li>
            @endif

            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('media.index') }}">
                    <i class="bi bi-images me-2"></i> Media Gallery
                </a>
            </li>
        @endif

        {{-- SETTINGS (Admin Only) --}}
        @if($isAdmin)
            <div class="small text-uppercase text-secondary mt-3 mb-2" style="font-size: 0.7rem;">Settings</div>
            <li class="nav-item mb-2">
                <a class="nav-link text-warning" href="{{ route('users.index') }}">
                    <i class="bi bi-people me-2"></i> Manage Users
                </a>
            </li>
        @endif

        {{-- VIEW SITE --}}
        <li class="nav-item mt-3">
            <a class="nav-link text-info small" href="{{ url('/') }}">
                <i class="bi bi-box-arrow-up-right me-2"></i> View Live Site
            </a>
        </li>

        {{-- LOGOUT --}}
        <li class="nav-item mt-auto pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</aside>