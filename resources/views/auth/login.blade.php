<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Background anime avec gradient comme la page d'accueil */
        .bg-animated {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 70%, #e82d2d 100%);
            z-index: -2;
        }
        /* Cercles flottants en arriere plan */
        .bg-circles {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
        }
        .circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.08;
            animation: float 8s infinite ease-in-out;
        }
        .circle-1 { width:400px; height:400px; background:#e82d2d; top:-100px; left:-100px; animation-delay:0s; }
        .circle-2 { width:300px; height:300px; background:#f5a623; bottom:-80px; right:-80px; animation-delay:2s; }
        .circle-3 { width:200px; height:200px; background:#4facfe; top:40%; left:60%; animation-delay:4s; }
        .circle-4 { width:150px; height:150px; background:#43e97b; top:20%; right:20%; animation-delay:1s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }

        /* Carte de connexion */
        .login-wrapper {
            display: flex;
            width: 900px;
            max-width: 95vw;
            min-height: 520px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
            backdrop-filter: blur(10px);
        }

        /* Panneau gauche - Branding */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #e82d2d, #f5a623);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -100px; right: -80px;
        }
        .login-left::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            bottom: -60px; left: -40px;
        }
        .login-left .logo-icon {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 36px; color: white;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
        }
        .login-left h1 {
            font-size: 28px; font-weight: 700;
            color: white; margin-bottom: 10px;
            position: relative; z-index: 1;
        }
        .login-left p {
            font-size: 14px; color: rgba(255,255,255,0.85);
            line-height: 1.7; position: relative; z-index: 1;
        }
        .login-left .features {
            margin-top: 30px; text-align: left;
            position: relative; z-index: 1; width: 100%;
        }
        .login-left .feature-item {
            display: flex; align-items: center; gap: 10px;
            color: rgba(255,255,255,0.9); font-size: 13px;
            margin-bottom: 12px;
        }
        .login-left .feature-item i {
            width: 28px; height: 28px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }

        /* Panneau droit - Formulaire */
        .login-right {
            flex: 1;
            background: rgba(255,255,255,0.97);
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right h2 {
            font-size: 24px; font-weight: 700;
            color: #1a1a2e; margin-bottom: 6px;
        }
        .login-right .subtitle {
            font-size: 13px; color: #888;
            margin-bottom: 30px;
        }

        /* Inputs */
        .form-floating label {
            font-size: 13px; color: #888;
        }
        .form-floating .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }
        .form-floating .form-control:focus {
            border-color: #e82d2d;
            box-shadow: 0 0 0 3px rgba(232,45,45,0.1);
        }
        .form-group-custom { margin-bottom: 18px; }

        /* Checkbox */
        .form-check-input:checked {
            background-color: #e82d2d;
            border-color: #e82d2d;
        }
        .form-check-label { font-size: 13px; color: #666; }

        /* Bouton connexion */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #e82d2d, #f5a623);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(232,45,45,0.4);
        }
        .btn-login:active { transform: translateY(0); }

        /* Message contact */
        .contact-msg {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #999;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
        .contact-msg i { color: #e82d2d; margin-right: 4px; }

        /* Erreur */
        .alert-error {
            background: #fff5f5;
            border: 1px solid #ffc9c9;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #c92a2a;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        /* Password toggle */
        .password-wrapper { position: relative; }
        .password-toggle {
            position: absolute;
            right: 15px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            font-size: 16px;
            z-index: 10;
            transition: color 0.2s;
        }
        .password-toggle:hover { color: #e82d2d; }

        /* Responsive */
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-right { padding: 40px 30px; }
            .login-wrapper { width: 100%; min-height: 100vh; border-radius: 0; }
        }
    </style>
</head>
<body>

    {{-- Background anime --}}
    <div class="bg-animated"></div>
    <div class="bg-circles">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
        <div class="circle circle-4"></div>
    </div>

    <div class="login-wrapper">

        {{-- PANNEAU GAUCHE - Branding --}}
        <div class="login-left">
            <div class="logo-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1>EduGest</h1>
            <p>Systeme de gestion scolaire<br>pour ecole primaire</p>

            <div class="features">
                <div class="feature-item">
                    <i class="bi bi-people-fill"></i>
                    Gestion des eleves et enseignants
                </div>
                <div class="feature-item">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    Bulletins et notes automatises
                </div>
                <div class="feature-item">
                    <i class="bi bi-calendar-check-fill"></i>
                    Suivi des presences
                </div>
                <div class="feature-item">
                    <i class="bi bi-cash-stack"></i>
                    Gestion des paiements
                </div>
            </div>
        </div>

        {{-- PANNEAU DROIT - Formulaire --}}
        <div class="login-right">
            <h2>Bon retour ! 👋</h2>
            <div class="subtitle">Connectez-vous a votre espace EduGest</div>

            {{-- Erreur --}}
            @if($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group-custom">
                    <label style="font-size:13px;font-weight:600;color:#444;margin-bottom:6px;display:block;">
                        <i class="bi bi-envelope me-1" style="color:#e82d2d;"></i> Adresse E-mail
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="exemple@ecole.com"
                        value="{{ old('email') }}"
                        required autofocus
                        style="border:2px solid #e9ecef;border-radius:12px;font-size:14px;padding:12px 16px;">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="form-group-custom">
                    <label style="font-size:13px;font-weight:600;color:#444;margin-bottom:6px;display:block;">
                        <i class="bi bi-lock me-1" style="color:#e82d2d;"></i> Mot de passe
                    </label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            required
                            style="border:2px solid #e9ecef;border-radius:12px;font-size:14px;padding:12px 16px;padding-right:45px;">
                        <i class="bi bi-eye-slash password-toggle" id="togglePassword"></i>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Se souvenir + mot de passe oublie --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:13px;color:#e82d2d;text-decoration:none;font-weight:500;">
                        Mot de passe oublie ?
                    </a>
                    @endif
                </div>

                {{-- Bouton connexion --}}
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                </button>

            </form>

            {{-- Message contact --}}
            <div class="contact-msg">
                <i class="bi bi-info-circle-fill"></i>
                Vous n'avez pas de compte ? Veuillez contacter l'administration de l'ecole.
            </div>

        </div>
    </div>

    <script>
    // Toggle mot de passe visible/cache
    document.getElementById('togglePassword').addEventListener('click', function() {
        const input = document.getElementById('passwordInput');
        if (input.type === 'password') {
            input.type = 'text';
            this.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            input.type = 'password';
            this.classList.replace('bi-eye', 'bi-eye-slash');
        }
    });
    </script>

</body>
</html>