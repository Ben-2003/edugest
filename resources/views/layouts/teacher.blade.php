<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Enseignant') — EduGest</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════
           VARIABLES — thème vert enseignant
           (différent du violet admin pour distinguer les espaces)
        ══════════════════════════════════════ */
        :root {
            --bg:       #0f1117;
            --surface:  #1a1d27;
            --surface2: #21253a;
            --border:   #2a2d3e;
            --text:     #e8eaf6;
            --muted:    #6b7280;
            --accent:   #10b981;   /* vert enseignant */
            --accent2:  #3b82f6;   /* bleu */
            --accent3:  #ff6b6b;   /* rouge erreur */
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--text); display:flex; min-height:100vh; }

        /* ── Sidebar enseignant ── */
        .sidebar { width:260px; background:var(--surface); border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; height:100vh; top:0; left:0; z-index:100; transition:all 0.3s; }

        /* Logo EduGest en haut de la sidebar */
        .sidebar-logo { padding:24px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
        .logo-icon { width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,var(--accent),#059669); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; flex-shrink:0; }
        .logo-text { font-size:18px; font-weight:700; }
        .logo-sub  { font-size:11px; color:var(--accent); font-weight:500; margin-top:1px; }

        /* Profil de l'enseignant connecté */
        .sidebar-profile { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
        .profile-avatar { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--accent),#059669); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; color:white; flex-shrink:0; }
        .profile-name { font-size:13px; font-weight:600; }
        .profile-role { font-size:11px; color:var(--accent); }

        /* Navigation sidebar */
        .sidebar-nav { flex:1; overflow-y:auto; padding:16px 12px; }
        .nav-section { font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1.5px; padding:0 8px; margin:16px 0 8px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--muted); text-decoration:none; font-size:13px; font-weight:500; transition:all 0.2s; margin-bottom:2px; }
        .nav-item:hover { background:var(--surface2); color:var(--text); }
        .nav-item.active { background:rgba(16,185,129,0.15); color:var(--accent); }
        .nav-item i { width:18px; text-align:center; font-size:14px; }

        /* Bouton déconnexion en bas */
        .sidebar-footer { padding:16px 12px; border-top:1px solid var(--border); }
        .btn-logout { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--accent3); text-decoration:none; font-size:13px; font-weight:500; transition:all 0.2s; width:100%; border:none; background:none; cursor:pointer; }
        .btn-logout:hover { background:rgba(255,107,107,0.1); }

        /* ── Zone principale ── */
        .main { margin-left:260px; flex:1; display:flex; flex-direction:column; min-height:100vh; }

        /* Topbar */
        .topbar { background:var(--surface); border-bottom:1px solid var(--border); padding:16px 32px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }
        .topbar-left { display:flex; flex-direction:column; gap:4px; }
        .page-title { font-size:18px; font-weight:700; }
        .breadcrumb-nav { font-size:12px; color:var(--muted); }
        .breadcrumb-nav a { color:var(--muted); text-decoration:none; }
        .breadcrumb-nav a:hover { color:var(--text); }
        .topbar-actions { display:flex; align-items:center; gap:10px; }

        /* Boutons globaux topbar */
        .btn-add { display:inline-flex; align-items:center; gap:7px; background:linear-gradient(135deg,var(--accent),#059669); color:white; border:none; border-radius:10px; padding:9px 18px; font-size:13px; font-weight:600; text-decoration:none; cursor:pointer; transition:all 0.2s; }
        .btn-add:hover { transform:translateY(-1px); box-shadow:0 6px 16px rgba(16,185,129,0.35); color:white; }
        .btn-back { display:inline-flex; align-items:center; gap:7px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:9px 18px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
        .btn-back:hover { color:var(--text); }
        .btn-edit-top { display:inline-flex; align-items:center; gap:7px; background:rgba(245,158,11,0.1); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); border-radius:10px; padding:9px 18px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
        .btn-edit-top:hover { background:rgba(245,158,11,0.2); color:#f59e0b; }

        /* Zone de contenu */
        .content { padding:32px; flex:1; }

        /* Alertes flash */
        .alert-success { background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); color:var(--accent); border-radius:12px; padding:12px 20px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; }
        .alert-error   { background:rgba(255,107,107,0.1); border:1px solid rgba(255,107,107,0.3); color:var(--accent3); border-radius:12px; padding:12px 20px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; }

        /* Animation fadeUp */
        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    </style>

    {{-- Styles spécifiques à chaque page --}}
    @yield('styles')
</head>
<body>

{{-- ══ SIDEBAR ENSEIGNANT ══ --}}
<aside class="sidebar">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
        <div>
            <div class="logo-text">EduGest</div>
            <div class="logo-sub">Espace Enseignant</div>
        </div>
    </div>

    {{-- Profil enseignant connecté --}}
    <div class="sidebar-profile">
        <div class="profile-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'E', 0, 1)) }}
        </div>
        <div>
            <div class="profile-name">{{ auth()->user()->name }}</div>
            <div class="profile-role"><i class="fas fa-circle" style="font-size:7px;"></i> Enseignant</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Tableau de bord --}}
        <a href="{{ route('teacher.dashboard') }}" class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Tableau de bord
        </a>

        <div class="nav-section">Mes cours</div>

        {{-- Mes classes --}}
        <a href="{{ route('teacher.grades.index') }}" class="nav-item {{ request()->routeIs('teacher.grades.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Notes
        </a>

        {{-- Mes absences --}}
        <a href="{{ route('teacher.attendances.index') }}" class="nav-item {{ request()->routeIs('teacher.attendances.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Appel / Absences
        </a>

        {{-- Emploi du temps en lecture seule --}}
        <a href="{{ route('teacher.schedules') }}" class="nav-item {{ request()->routeIs('teacher.schedules') ? 'active' : '' }}">
            <i class="fas fa-clock"></i> Mon emploi du temps
        </a>

    </nav>

    {{-- Déconnexion --}}
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </div>

</aside>

{{-- ══ ZONE PRINCIPALE ══ --}}
<div class="main">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="topbar-left">
            <div class="page-title">@yield('page-title', 'Tableau de bord')</div>
            <div class="breadcrumb-nav">@yield('breadcrumb')</div>
        </div>
        <div class="topbar-actions">
            @yield('topbar-actions')
        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="content">

        {{-- Alertes flash --}}
        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ $errors->first() }}
        </div>
        @endif

        @yield('content')
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>