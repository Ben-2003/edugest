<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Parent') — EduGest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:      #0f1117;
            --surface: #1a1d27;
            --surface2:#21253a;
            --border:  #2a2d3e;
            --text:    #e8eaf6;
            --muted:   #6b7280;
            --accent:  #3b82f6;   /* bleu parent */
            --accent3: #ff6b6b;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--text); display:flex; min-height:100vh; }

        /* Sidebar */
        .sidebar { width:260px; background:var(--surface); border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; height:100vh; }
        .sidebar-logo { padding:24px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
        .logo-icon { width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,var(--accent),#2563eb); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
        .logo-text { font-size:18px; font-weight:700; }
        .logo-sub  { font-size:11px; color:var(--accent); font-weight:500; margin-top:1px; }

        .sidebar-profile { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
        .profile-avatar { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--accent),#2563eb); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; color:white; }
        .profile-name { font-size:13px; font-weight:600; }
        .profile-role { font-size:11px; color:var(--accent); }

        .sidebar-nav { flex:1; padding:16px 12px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--muted); text-decoration:none; font-size:13px; font-weight:500; transition:all 0.2s; margin-bottom:2px; }
        .nav-item:hover { background:var(--surface2); color:var(--text); }
        .nav-item.active { background:rgba(59,130,246,0.15); color:var(--accent); }
        .nav-item i { width:18px; text-align:center; }

        .sidebar-footer { padding:16px 12px; border-top:1px solid var(--border); }
        .btn-logout { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--accent3); text-decoration:none; font-size:13px; font-weight:500; transition:all 0.2s; width:100%; border:none; background:none; cursor:pointer; }
        .btn-logout:hover { background:rgba(255,107,107,0.1); }

        /* Main */
        .main { margin-left:260px; flex:1; display:flex; flex-direction:column; }
        .topbar { background:var(--surface); border-bottom:1px solid var(--border); padding:16px 32px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }
        .page-title { font-size:18px; font-weight:700; }
        .breadcrumb-nav { font-size:12px; color:var(--muted); }
        .breadcrumb-nav a { color:var(--muted); text-decoration:none; }
        .content { padding:32px; flex:1; }

        .alert-success { background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.3); color:var(--accent); border-radius:12px; padding:12px 20px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; }
        .alert-error { background:rgba(255,107,107,0.1); border:1px solid rgba(255,107,107,0.3); color:var(--accent3); border-radius:12px; padding:12px 20px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; }

        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    </style>
    @yield('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
        <div>
            <div class="logo-text">EduGest</div>
            <div class="logo-sub">Espace Parent</div>
        </div>
    </div>
    <div class="sidebar-profile">
        <div class="profile-avatar">
            {{ strtoupper(substr(auth()->user()->first_name ?? 'P', 0, 1)) }}
        </div>
        <div>
            <div class="profile-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="profile-role"><i class="fas fa-circle" style="font-size:7px;"></i> Parent</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('parent.dashboard') }}" class="nav-item {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Tableau de bord
        </a>
    </nav>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <div class="page-title">@yield('page-title', 'Tableau de bord')</div>
            <div class="breadcrumb-nav">@yield('breadcrumb')</div>
        </div>
    </div>
    <div class="content">
        @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>