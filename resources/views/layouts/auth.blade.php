<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>EduGest — @yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg: #0f1117;
            --surface: #1a1d27;
            --surface2: #22263a;
            --border: rgba(255, 255, 255, 0.07);
            --text: #f0f0f5;
            --muted: #7a7f9a;
            --accent: #6c63ff;
            --accent2: #00d4aa;
            --accent3: #ff6b6b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DM Sans', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .auth-logo img {
            height: 60px;
            width: auto;
        }

        .auth-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            text-align: center;
        }

        .auth-subtitle {
            font-size: 14px;
            color: var(--muted);
            text-align: center;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text);
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-group input::placeholder {
            color: var(--muted);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent);
            background: var(--surface);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.1);
        }

        .form-group input.is-invalid {
            border-color: var(--accent3);
            background: rgba(255, 107, 107, 0.05);
        }

        .form-group input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
        }

        .invalid-feedback {
            display: block;
            color: var(--accent3);
            font-size: 13px;
            margin-top: 6px;
        }

        .form-check {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .form-check input {
            width: auto !important;
            margin-right: 8px;
            padding: 0;
            accent-color: var(--accent);
        }

        .form-check label {
            margin-bottom: 0;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #8a79ff;
            text-decoration: underline;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--accent), #5a52d5);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(108, 99, 255, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        .auth-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .auth-card {
                padding: 30px 20px;
            }

            .auth-title {
                font-size: 20px;
            }

            .btn-login {
                padding: 10px 24px;
                font-size: 13px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="auth-container">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    
    @yield('scripts')
</body>
</html>
