<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Espace Enseignant</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f1117;
            --surface: #1a1d27;
            --surface2: #22263a;
            --border: rgba(255,255,255,0.07);
            --text: #f0f0f5;
            --muted: #7a7f9a;
            --accent: #00d4aa;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'DM Sans',sans-serif; }
        body { background: var(--bg); color: var(--text); display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .container {
            text-align: center;
            padding: 40px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
        }
        .icon {
            width: 70px; height: 70px;
            background: rgba(0,212,170,0.15);
            border-radius: 20px;
            display: flex; align-items:center; justify-content:center;
            margin: 0 auto 20px;
            font-size: 30px;
            color: var(--accent);
        }
        h2 { font-size: 22px; font-weight: 700; margin-bottom: 8px; }
        p { color: var(--muted); font-size: 14px; margin-bottom: 24px; }
        .badge {
            background: rgba(0,212,170,0.1);
            border: 1px solid rgba(0,212,170,0.3);
            color: var(--accent);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            color: #ff6b6b;
            font-size: 13px;
            cursor: pointer;
            background: none;
            border: none;
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <h2>Espace Enseignant</h2>
        <p>Bienvenue {{ Auth::user()->first_name }} ! Votre espace est en cours de construction. 🚧</p>
        <span class="badge">🎓 Enseignant</span>
        <br>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </button>
        </form>
    </div>
</body>
</html>