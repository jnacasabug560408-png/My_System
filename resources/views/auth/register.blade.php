<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | CMS Portal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --outer-bg: #e0f2fe; /* Match your light navy blue background */
            --card-bg: #ffffff;
            --accent-blue: #2563eb;
            --text-main: #1e293b;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--outer-bg);
            /* Soft lighting to match the login page */
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
            max-width: 1100px; /* Slightly wider for registration forms */
            min-height: 700px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.4);
            border: none;
        }

        /* Left Side: Brand/Visual */
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

        /* Right Side: Form Content */
        .auth-content {
            width: 60%;
            padding: 50px 70px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .brand-logo {
            color: var(--accent-blue);
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .form-control {
            padding: 10px 15px;
            border-radius: 10px;
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

        .btn-register {
            background: var(--accent-blue);
            color: white;
            font-weight: 600;
            padding: 14px;
            border-radius: 12px;
            border: none;
            margin-top: 15px;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: #64748b;
        }

        .login-link a {
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
            <h2 class="fw-bold">Join the community.</h2>
            <p class="opacity-75">Create your account to start managing your content with our powerful CMS tools.</p>
        </div>

        <div class="auth-content">
            <div class="brand-logo">
                <i class="bi bi-box-seam-fill"></i> CMS
            </div>

            <h3 class="fw-bold text-dark mb-1">Create Account</h3>
            <p class="text-muted mb-4 small">Fill in your details to get started.</p>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                               name="username" value="{{ old('username') }}" placeholder="j_maccoy" required>
                        @error('username') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" placeholder="James Maccoy" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" placeholder="name@company.com" required>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" placeholder="••••••••" required>
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               name="password_confirmation" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-register w-100">
                    <i class="bi bi-person-plus-fill me-2"></i>Create My Account
                </button>
            </form>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>