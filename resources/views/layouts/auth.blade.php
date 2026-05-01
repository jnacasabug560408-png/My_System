<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
        }

        /* LEFT SIDE (IMAGE) */
        .auth-image {
            flex: 1;
            background: linear-gradient(135deg, #0F172A, #1E293B);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
        }

        .auth-image h1 {
            font-size: 40px;
            font-weight: 700;
        }

        .auth-image p {
            opacity: 0.8;
        }

        /* RIGHT SIDE (FORM) */
        .auth-form {
            flex: 1;
            background: #F8FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .auth-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1E293B;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .btn-primary {
            background: #3B82F6;
            border: none;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.25);
        }

        .btn-primary:hover {
            background: #2563EB;
        }

        .auth-links a {
            color: #3B82F6;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .auth-image {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="auth-container">
    
    <!-- LEFT IMAGE SIDE -->
    <div class="auth-image">
        <div>
            <h1>CMS Platform</h1>
            <p>Manage your content efficiently with a modern and powerful system.</p>
        </div>
    </div>

    <!-- RIGHT FORM SIDE -->
    <div class="auth-form">
        @yield('content')
    </div>

</div>

</body>
</html>