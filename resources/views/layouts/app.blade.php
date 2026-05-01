<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMS') - Content Management System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
    /* Your New Outer Background Color */
    --outer-bg: #e0f2fe; 
    
    /* Other Palette Colors */
    --primary-navy: #0f172a;
    --secondary-slate: #1e293b;
    --accent-blue: #38bdf8;
    --text-muted: #94a3b8;
    
    /* Status Colors */
    --success: #10b981;
    --danger: #ef4444;
}

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

       body {
        /* Applying the Sky Blue to the entire outer background */
            background-color: var(--outer-bg) !important;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #334155;
            margin: 0;
        }

        /* --- UPDATED SIDEBAR --- */
        .sidebar {
            background: linear-gradient(180deg, var(--primary-navy) 0%, var(--secondary-slate) 100%) !important;
            color: white;
            min-height: 100vh;
            position: fixed;
            width: 260px;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(0,0,0,0.05);
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .sidebar .brand {
            padding: 30px 25px;
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.5px;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar hr {
            border-top: 1px solid rgba(255,255,255,0.05);
            margin: 15px 20px;
            opacity: 1;
        }

        .sidebar a {
            color: var(--text-muted);
            text-decoration: none;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar a i {
            font-size: 1.1rem;
            transition: color 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.05);
            color: white !important;
            border-left-color: var(--accent-blue);
        }

        .sidebar a:hover i,
        .sidebar a.active i {
            color: var(--accent-blue);
        }

        /* --- MAIN WRAPPER & TOPBAR --- */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            background-color: var(--outer-bg);
        }
        .topbar {
            background-color: #f5f7fa;
            padding: 18px 40px;
            /* This changes the color of the line you highlighted */
            border-bottom: 2px solid #e2e8f0; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar h1 {
            margin: 0;
            color: var(--primary-navy);
            font-size: 20px;
            font-weight: 700;
        }

        .user-name {
            font-weight: 600;
            color: var(--primary-navy);
            font-size: 14px;
        }

        /* --- CONTENT CARDS --- */
        .content {
            padding: 40px;
            background-color: var(--outer-bg);
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            background: white;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px 25px;
            border-radius: 16px 16px 0 0 !important;
        }

        /* Table Style Polish */
        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #64748b;
            border-top: none;
        }

        @media (max-width: 768px) {
            .sidebar { width: 0; transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <i class="bi bi-cloud-check-fill text-info"></i>
            <span>CMS</span>
        </div>

        @auth
            {{-- ALWAYS VISIBLE --}}
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            {{-- 1. ADDED: MY COMMENTS (Lilitaw lang para sa Subscriber) --}}
            @if(Auth::user()->role === 'subscriber')
                <a href="{{ route('subscriber.comments') }}" class="{{ request()->routeIs('subscriber.comments') ? 'active' : '' }}">
                    <i class="bi bi-chat-left-text-fill text-info"></i> My Comments
                </a>
            @endif

            {{-- VISIBLE TO CREATOR, AUTHOR, EDITOR, ADMIN --}}
            @if(Auth::user()->canCreateContent())
                <a href="{{ route('contents.index') }}" class="{{ request()->routeIs('contents.index') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i> My Content
                </a>
                <a href="{{ route('contents.create') }}" class="{{ request()->routeIs('contents.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-square-fill"></i> Create Post
                </a>
                <a href="{{ route('media.index') }}" class="{{ request()->routeIs('media.*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i> Media Gallery
                </a>
            @endif

            {{-- VISIBLE TO EDITOR OR ADMIN (Moderate Comments) --}}
            @if(Auth::user()->isEditor() || Auth::user()->isAdmin())
                <hr>
                <a href="{{ route('comments.index') }}" class="{{ request()->routeIs('comments.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-square-dots-fill"></i>Comments
                </a>
            @endif

            {{-- ADMIN ONLY SECTION --}}
            @if(Auth::user()->isAdmin())
                <hr>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Users
                </a>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-folder-fill"></i> Categories
                </a>
                <a href="{{ route('contents.moderation') }}" class="{{ request()->routeIs('contents.moderation') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock-fill"></i> Moderation
                </a>
                <a href="{{ route('analytics') }}" class="{{ request()->routeIs('analytics') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i> Analytics
                </a>
            @endif

            <hr>
            <a href="{{ route('posts.public.index') }}">
                <i class="bi bi-browser-safari text-accent"></i> View Site
            </a>
            <a href="{{ route('logout') }}" class="text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-power"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endauth
    </aside>

    <div class="main-wrapper">
        <div class="topbar">
            <h1>@yield('page-title', 'Dashboard')</h1>
            @auth
            <div class="user-menu">
                <div class="user-info d-flex align-items: center; gap: 12px;">
                    <div class="text-end">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="badge bg-light text-primary border" style="font-size: 10px;">{{ strtoupper(Auth::user()->role) }}</div>
                    </div>
                    <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 40px; height: 40px; font-weight: 700;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
            @endauth
        </div>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>