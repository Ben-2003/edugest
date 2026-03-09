{{-- ============================================================
     LAYOUT PRINCIPAL ADMIN — EduGest
     Toutes les vues admin héritent de ce layout via @extends
     Il contient : sidebar, topbar, alerts, et zones @yield
     ============================================================ --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Titre dynamique : chaque vue définit son propre titre --}}
    <title>EduGest — @yield('title')</title>

    {{-- Polices Google : DM Sans (texte) + DM Serif Display (logo) --}}
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">

    {{-- Font Awesome : icônes utilisées dans toute l'application --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ── Variables CSS globales ──
           Palette dark mode utilisée dans toute l'application */
        :root {
            --bg:#0f1117;           /* Fond principal */
            --surface:#1a1d27;      /* Fond des cartes */
            --surface2:#22263a;     /* Fond des inputs et hover */
            --border:rgba(255,255,255,0.07); /* Bordures subtiles */
            --text:#f0f0f5;         /* Texte principal */
            --muted:#7a7f9a;        /* Texte secondaire / labels */
            --accent:#6c63ff;       /* Violet — couleur principale */
            --accent2:#00d4aa;      /* Vert — couleur secondaire */
            --accent3:#ff6b6b;      /* Rouge — erreurs / danger */
            --sidebar-w:260px;      /* Largeur fixe de la sidebar */
        }

        /* ── Reset global ── */
        * { margin:0; padding:0; box-sizing:border-box; font-family:'DM Sans',sans-serif; }
        body { background:var(--bg); color:var(--text); display:flex; min-height:100vh; }

        /* ════════════════════════════════
           SIDEBAR
           Fixe à gauche, hauteur 100vh
           ════════════════════════════════ */
        .sidebar {
            width:var(--sidebar-w);
            height:100vh;
            background:var(--surface);
            border-right:1px solid var(--border);
            display:flex;
            flex-direction:column;
            position:fixed;
            top:0; left:0;
            overflow-y:auto;
        }

        /* Logo EduGest en haut de la sidebar */
        .sidebar-logo { padding:28px 24px 24px; border-bottom:1px solid var(--border); }
        .logo-text { font-family:'DM Serif Display',serif; font-size:22px; color:var(--text); }
        .logo-badge { font-size:10px; color:var(--muted); letter-spacing:2px; text-transform:uppercase; }

        /* Bloc utilisateur connecté */
        .sidebar-user { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
        .avatar { width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:15px; color:white; flex-shrink:0; }
        .user-name { font-size:14px; font-weight:600; }
        .user-role { font-size:11px; color:var(--accent); }

        /* Navigation principale */
        .sidebar-nav { flex:1; padding:16px 12px; }
        .nav-section-label { font-size:10px; letter-spacing:2px; text-transform:uppercase; color:var(--muted); padding:12px 12px 6px; font-weight:500; }

        /* Lien de navigation */
        .nav-item { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--muted); text-decoration:none; font-size:14px; font-weight:500; transition:all 0.2s; margin-bottom:2px; }
        .nav-item:hover { background:var(--surface2); color:var(--text); }

        /* Lien actif — détecté automatiquement via request()->routeIs() */
        .nav-item.active { background:linear-gradient(135deg,rgba(108,99,255,0.2),rgba(0,212,170,0.1)); color:var(--text); border:1px solid rgba(108,99,255,0.3); }
        .nav-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px; background:var(--surface2); flex-shrink:0; }
        .nav-item.active .nav-icon { background:var(--accent); color:white; }

        /* Bouton de déconnexion */
        .sidebar-footer { padding:16px 12px; }
        .logout-btn { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--accent3); font-size:14px; font-weight:600; background:rgba(255,107,107,0.08); border:1px solid rgba(255,107,107,0.15); cursor:pointer; width:100%; }

        /* ════════════════════════════════
           ZONE PRINCIPALE (droite)
           Décalée de la largeur de la sidebar
           ════════════════════════════════ */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; }

        /* Barre supérieure sticky */
        .topbar { padding:20px 32px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--surface); position:sticky; top:0; z-index:50; }
        .topbar-left { flex:1; }
        .topbar-title { font-size:18px; font-weight:600; }
        .topbar-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .topbar-subtitle a { color:var(--muted); text-decoration:none; }
        .topbar-actions { display:flex; gap:10px; }

        /* Zone de contenu principal */
        .content { padding:32px; }

        /* ════════════════════════════════
           ALERTES FLASH
           Affichées après une action CRUD
           ════════════════════════════════ */

        /* Alerte succès — fond vert transparent */
        .alert-success { background:rgba(0,212,170,0.1); border:1px solid rgba(0,212,170,0.3); color:var(--accent2); border-radius:12px; padding:14px 20px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; font-weight:500; animation:fadeUp 0.3s ease both; }

        /* Alerte erreur — fond rouge transparent */
        .alert-error { background:rgba(255,107,107,0.1); border:1px solid rgba(255,107,107,0.3); color:var(--accent3); border-radius:12px; padding:14px 20px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; }

        /* Animation d'apparition utilisée sur les cartes */
        @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

        /* ════════════════════════════════
           BOUTONS TOPBAR GLOBAUX
           Définis ici car rendus dans le layout
           via @yield('topbar-actions')
           ════════════════════════════════ */

        /* Bouton principal violet — Ajouter */
        .btn-add {
            display:flex;
            align-items:center;
            gap:8px;
            background:linear-gradient(135deg,var(--accent),#5a52d5);
            color:white;
            border:none;
            border-radius:10px;
            padding:11px 20px;
            font-size:14px;
            font-weight:600;
            cursor:pointer;
            text-decoration:none;
            transition:all 0.2s;
            white-space:nowrap;
        }
        .btn-add:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }

        /* Bouton retour gris */
        .btn-back {
            display:flex;
            align-items:center;
            gap:8px;
            background:var(--surface2);
            color:var(--muted);
            border:1px solid var(--border);
            border-radius:10px;
            padding:10px 20px;
            font-size:13px;
            font-weight:600;
            text-decoration:none;
            transition:all 0.2s;
        }
        .btn-back:hover { color:var(--text); }

        /* Bouton modifier orange — utilisé dans les pages show */
        .btn-edit-top {
            display:flex;
            align-items:center;
            gap:8px;
            background:linear-gradient(135deg,#f59e0b,#d97706);
            color:white;
            border:none;
            border-radius:10px;
            padding:10px 20px;
            font-size:13px;
            font-weight:600;
            text-decoration:none;
            transition:all 0.2s;
        }
        .btn-edit-top:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(245,158,11,0.3); }

    </style>

    {{-- ── Styles spécifiques à chaque vue enfant ──
         IMPORTANT : placé APRÈS </style> pour éviter les conflits
         Chaque vue peut définir son propre bloc <style> ici --}}
    @yield('styles')

</head>
<body>

{{-- ════════════════════════════════
     SIDEBAR — Navigation principale
     Active automatiquement le lien
     courant via request()->routeIs()
     ════════════════════════════════ --}}
<aside class="sidebar">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="logo-text">🏫 EduGest</div>
        <div class="logo-badge">Système de gestion scolaire</div>
    </div>

    {{-- Utilisateur connecté --}}
    <div class="sidebar-user">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}</div>
        <div>
            <div class="user-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="user-role">{{ ucfirst(auth()->user()->role->role_name) }}</div>
        </div>
    </div>

    {{-- Liens de navigation --}}
    <nav class="sidebar-nav">

        {{-- Section : Principal --}}
        <div class="nav-section-label">Principal</div>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-chart-pie"></i></div> Tableau de bord
        </a>

        {{-- Section : Gestion --}}
        <div class="nav-section-label">Gestion</div>
        <a href="{{ route('admin.students.index') }}"
           class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-user-graduate"></i></div> Élèves
        </a>
        <a href="{{ route('admin.teachers.index') }}"
           class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></div> Enseignants
        </a>
        <a href="{{ route('admin.classes.index') }}"
           class="nav-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-school"></i></div> Classes
        </a>
        <a href="{{ route('admin.subjects.index') }}"
           class="nav-item {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-book"></i></div> Matières
        </a>
        <a href="{{ route('admin.enrollments.index') }}"
           class="nav-item {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-user-plus"></i></div> Inscriptions
        </a>

        {{-- Section : Académique --}}
        <div class="nav-section-label">Académique</div>
        <a href="{{ route('admin.grades.index') }}"
           class="nav-item {{ request()->routeIs('admin.grades.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-star"></i></div> Notes
        </a>
        <a href="{{ route('admin.attendances.index') }}"
           class="nav-item {{ request()->routeIs('admin.attendances.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-calendar-check"></i></div> Absences
        </a>
        <a href="{{ route('admin.report-cards.index') }}"
           class="nav-item {{ request()->routeIs('admin.report-cards.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-file-alt"></i></div> Bulletins
        </a>
        <a href="{{ route('admin.schedules.index') }}"
           class="nav-item {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-clock"></i></div> Emploi du temps
        </a>

        {{-- Section : Finance --}}
        <div class="nav-section-label">Finance</div>
        <a href="{{ route('admin.payments.index') }}"
           class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-money-bill-wave"></i></div> Paiements
        </a>

    </nav>

    {{-- Bouton déconnexion --}}
    <div class="sidebar-footer">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
        <button onclick="document.getElementById('logout-form').submit();" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </button>
    </div>

</aside>

{{-- ════════════════════════════════
     ZONE PRINCIPALE
     Topbar + Alertes + Contenu
     ════════════════════════════════ --}}
<div class="main">

    {{-- Barre supérieure sticky --}}
    <div class="topbar">
        <div class="topbar-left">
            {{-- Titre et fil d'ariane définis par chaque vue --}}
            <div class="topbar-title">@yield('page-title')</div>
            <div class="topbar-subtitle">@yield('breadcrumb')</div>
        </div>
        <div class="topbar-actions">
            {{-- Boutons d'action définis par chaque vue (ex: + Ajouter) --}}
            @yield('topbar-actions')
        </div>
    </div>

    {{-- Zone de contenu --}}
    <div class="content">

        {{-- Alerte succès après une action CRUD réussie --}}
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Alerte erreur si validation échoue --}}
        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        {{-- Contenu principal — défini par chaque vue enfant --}}
        @yield('content')

    </div>
</div>

{{-- Scripts spécifiques à chaque vue (ex: Chart.js, recherche JS) --}}
@yield('scripts')

</body>
</html>