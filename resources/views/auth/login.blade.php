<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CMS Portal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --outer-bg: #e0f2fe;
            
            --card-bg: #ffffff;
            --accent-blue: #2563eb;
            --text-main: #1e293b;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            
            /* Background outside the interface */
            background-color: var(--outer-bg);
            
            /* Soft radial lighting to give the Navy depth */
            background-image: 
                radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.2) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(15, 23, 42, 0.3) 0px, transparent 50%);
            
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: var(--card-bg);
            border-radius: 28px;
            overflow: hidden;
            display: flex;
            width: 100%;
            max-width: 1050px;
            min-height: 620px;
            /* Shadow adjusted for the Navy background */
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.4);
            border: none;
        }

        /* Sidebar Image Section */
        .auth-aside {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85), rgba(51, 65, 85, 0.7)), 
                        url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px 40px;
            color: white;
        }

        .auth-aside h2 {
            font-weight: 700;
            font-size: 2.2rem;
            line-height: 1.2;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .auth-aside p {
            color: #e2e8f0;
            font-size: 1.1rem;
        }

        /* Form Content Section */
        .auth-content {
            width: 55%;
            padding: 60px 80px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            color: var(--accent-blue);
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.875rem;
            margin-bottom: 8px;
        }

        .form-control {
            padding: 14px 18px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: 0.2s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .btn-submit {
            background: var(--accent-blue);
            color: white;
            font-weight: 600;
            padding: 16px;
            border-radius: 14px;
            border: none;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
        }

        .footer-text {
            margin-top: 40px;
            text-align: center;
            font-size: 0.95rem;
            color: #64748b;
        }

        .footer-text a {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .auth-aside { display: none; }
            .auth-content { width: 100%; padding: 40px; }
            .auth-card { max-width: 500px; min-height: auto; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">
        
        <div class="auth-aside">
            <h2>The smarter way <br>to manage content.</h2>
            <p>Streamline your publishing workflow with our integrated CMS tools.</p>
        </div>

        <div class="auth-content">
            <div class="brand-logo">
                <i class="bi bi-box-seam-fill"></i> CMS
            </div>

            <h3 class="fw-bold text-dark mb-1">Sign in</h3>
            <p class="text-muted mb-4">Please enter your credentials below.</p>

            @if ($errors->any())
                <div class="alert alert-danger py-2 small border-0 shadow-sm mb-4">
                    @foreach ($errors->all() as $error)
                        <div><i class="bi bi-exclamation-circle-fill me-2"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Email or Username</label>
                    <input type="text" class="form-control" name="login" placeholder="e.g. j_maccoy" required autofocus>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Password</label>
                        <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none fw-semibold">Forgot?</a>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label small text-muted" for="remember">Keep me signed in</label>
                    </div>
                </div>

                <button type="submit" class="btn-submit w-100">Login to Account</button>
            </form>

            <div class="footer-text">
                Don't have an account yet? <a href="{{ route('register') }}">Create an account</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>