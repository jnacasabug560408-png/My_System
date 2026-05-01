<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS - Content Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #3B82F6;
            --primary-dark: #2563EB;
            --navy: #0F172A;
            --slate-800: #1E293B;
            --slate-600: #475569;
            --bg-light: #F8FAFC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--slate-600);
        }

        h1, h2, h3 {
            color: var(--slate-800);
        }

        /* Navigation */
        nav {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            color: var(--navy);
        }

        /* Hero */
        .hero {
            background: var(--navy);
            color: white;
            padding: 100px 0;
            text-align: center;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: white;
            animation: slideInDown 0.8s ease-out;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #cbd5e1;
            animation: slideInUp 0.8s ease-out 0.2s backwards;
        }

        .hero-buttons {
            animation: slideInUp 0.8s ease-out 0.4s backwards;
        }

        .btn-hero {
            padding: 12px 35px;
            margin: 10px;
            font-size: 16px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-hero-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.25);
        }

        .btn-hero-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-hero-secondary {
            background: transparent;
            color: white;
            border: 1px solid #94a3b8;
        }

        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.08);
        }

        /* Animations (unchanged) */
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Features */
        .features {
            padding: 80px 0;
            background: var(--bg-light);
        }

        .features h2 {
            text-align: center;
            margin-bottom: 50px;
            font-size: 36px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            padding: 30px;
            text-align: center;
            border-radius: 12px;
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.08);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #EFF6FF;
            color: var(--primary);
            font-size: 24px;
        }

        /* Stats */
        .stats {
            padding: 60px 0;
            background: var(--navy);
            color: white;
        }

        .stat-number {
            font-size: 40px;
            font-weight: 700;
        }

        .stat-label {
            color: #cbd5e1;
        }

        /* How It Works */
        .how-it-works {
            padding: 80px 0;
        }

        .how-it-works h2 {
            text-align: center;
            margin-bottom: 50px;
            font-size: 36px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* CTA */
        .cta {
            background: var(--navy);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .btn-light {
            background: var(--primary);
            color: white;
        }

        .btn-outline-light {
            border: 1px solid #94a3b8;
            color: white;
        }

        .btn-outline-light:hover {
            background: rgba(255,255,255,0.08);
        }

        /* Footer */
        footer {
            background: #020617;
            color: #94a3b8;
            padding: 40px 0;
            text-align: center;
        }

        /* Responsive (unchanged) */
        @media (max-width: 768px) {
            .hero h1 { font-size: 32px; }
            .hero p { font-size: 16px; }
        }
    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-newspaper"></i> CMS
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav"></button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li><a class="nav-link" href="#features">Features</a></li>
                <li><a class="nav-link" href="#how">How It Works</a></li>
                <li><a class="nav-link btn btn-primary text-white ms-2" href="/login">Login</a></li>
                <li><a class="nav-link btn btn-outline-primary ms-2" href="/register">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="container">
        <h1>Welcome to Nacasabug Creative Content Management System</h1>
        <p>A Modern Content Management System for Creating, Managing, and Publishing Your Content</p>
        <div class="hero-buttons">
            <a href="/login" class="btn-hero btn-hero-primary">Login</a>
            <a href="/register" class="btn-hero btn-hero-secondary">Register</a>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features" id="features">
    <div class="container">
        <h2>Powerful Features</h2>
        <div class="feature-grid">

            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-file-earmark-text"></i></div>
                <h3>Content Management</h3>
                <p>Create, edit, and publish engaging content.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-folder"></i></div>
                <h3>Category & Tags</h3>
                <p>Organize your content efficiently.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-image"></i></div>
                <h3>Media Management</h3>
                <p>Manage media files in one place.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-people"></i></div>
                <h3>User Management</h3>
                <p>Control access with roles.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-chat-left-text"></i></div>
                <h3>Comments</h3>
                <p>Engage with your users.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="bi bi-graph-up"></i></div>
                <h3>Analytics</h3>
                <p>Track performance easily.</p>
            </div>

        </div>
    </div>
</section>

<!-- Stats -->
<section class="stats">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-3"><div class="stat-number">7</div><div>Core Modules</div></div>
            <div class="col-md-3"><div class="stat-number">5</div><div>User Roles</div></div>
            <div class="col-md-3"><div class="stat-number">30+</div><div>API Routes</div></div>
            <div class="col-md-3"><div class="stat-number">100%</div><div>Open Source</div></div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works" id="how">
    <div class="container">
        <h2>How It Works</h2>
        <div class="steps-grid">

            <div><div class="step-number">1</div><h3>Register</h3><p>Create account.</p></div>
            <div><div class="step-number">2</div><h3>Create</h3><p>Make content.</p></div>
            <div><div class="step-number">3</div><h3>Organize</h3><p>Use categories.</p></div>
            <div><div class="step-number">4</div><h3>Publish</h3><p>Go live.</p></div>
            <div><div class="step-number">5</div><h3>Engage</h3><p>Get feedback.</p></div>
            <div><div class="step-number">6</div><h3>Analyze</h3><p>Track results.</p></div>

        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <h2>Ready to Get Started?</h2>
    <a href="/register" class="btn btn-light">Create Account</a>
</section>

<!-- Footer -->
<footer>
    <p>© 2024 Content Management System</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>