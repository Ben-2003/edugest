<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Profil Élève</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #0f1117; --surface: #1a1d27; --surface2: #22263a;
            --border: rgba(255,255,255,0.07); --text: #f0f0f5;
            --muted: #7a7f9a; --accent: #6c63ff; --accent2: #00d4aa;
            --accent3: #ff6b6b; --sidebar-w: 260px;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'DM Sans',sans-serif; }
        body { background:var(--bg); color:var(--text); display:flex; min-height:100vh; }

        /* SIDEBAR */
        .sidebar { width:var(--sidebar-w); height:100vh; background:var(--surface); border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; top:0; left:0; overflow-y:auto; }
        .sidebar-logo { padding:28px 24px 24px; border-bottom:1px solid var(--border); }
        .logo-text { font-family:'DM Serif Display',serif; font-size:22px; color:var(--text); }
        .logo-badge { font-size:10px; color:var(--muted); letter-spacing:2px; text-transform:uppercase; }
        .sidebar-user { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
        .avatar { width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:15px; color:white; flex-shrink:0; }
        .user-name { font-size:14px; font-weight:600; }
        .user-role { font-size:11px; color:var(--accent); }
        .sidebar-nav { flex:1; padding:16px 12px; }
        .nav-section-label { font-size:10px; letter-spacing:2px; text-transform:uppercase; color:var(--muted); padding:12px 12px 6px; font-weight:500; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--muted); text-decoration:none; font-size:14px; font-weight:500; transition:all 0.2s; margin-bottom:2px; }
        .nav-item:hover { background:var(--surface2); color:var(--text); }
        .nav-item.active { background:linear-gradient(135deg,rgba(108,99,255,0.2),rgba(0,212,170,0.1)); color:var(--text); border:1px solid rgba(108,99,255,0.3); }
        .nav-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px; background:var(--surface2); flex-shrink:0; }
        .nav-item.active .nav-icon { background:var(--accent); color:white; }
        .sidebar-footer { padding:16px 12px; }
        .logout-btn { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--accent3); text-decoration:none; font-size:14px; font-weight:600; background:rgba(255,107,107,0.08); border:1px solid rgba(255,107,107,0.15); cursor:pointer; width:100%; }

        /* MAIN */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; }
        .topbar { padding:20px 32px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--surface); position:sticky; top:0; z-index:50; }
        .topbar-title { font-size:18px; font-weight:600; }
        .topbar-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .topbar-subtitle a { color:var(--muted); text-decoration:none; }
        .topbar-actions { display:flex; gap:10px; }
        .content { padding:32px; }

        /* PROFILE CARD */
        .profile-header { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:32px; display:flex; align-items:center; gap:24px; margin-bottom:24px; animation:fadeUp 0.3s ease both; }
        .profile-avatar { width:80px; height:80px; border-radius:20px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:700; color:white; flex-shrink:0; }
        .profile-info h1 { font-size:22px; font-weight:700; margin-bottom:4px; }
        .profile-info .reg { font-size:13px; color:var(--muted); margin-bottom:12px; }
        .badge { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; }
        .badge-m { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); }
        .badge-f { background:rgba(255,107,107,0.15); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); }
        .profile-actions { margin-left:auto; display:flex; gap:10px; }

        /* INFO GRID */
        .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; animation:fadeUp 0.3s ease 0.1s both; }
        .info-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; }
        .info-card-title { font-size:13px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
        .info-card-title i { color:var(--accent); }
        .info-row { display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid var(--border); }
        .info-row:last-child { border-bottom:none; padding-bottom:0; }
        .info-label { font-size:13px; color:var(--muted); }
        .info-value { font-size:13px; font-weight:600; color:var(--text); }

        /* BUTTONS */
        .btn-edit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; }
        .btn-edit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
        .btn-back { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; }
        .btn-back:hover { color:var(--text); }
        .btn-delete { display:flex; align-items:center; gap:8px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; }
        .btn-delete:hover { background:rgba(255,107,107,0.2); }

        @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-text">🏫 EduGest</div>
        <div class="logo-badge">Système de gestion scolaire</div>
    </div>
    <div class="sidebar-user">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}</div>
        <div>
            <div class="user-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="user-role">{{ ucfirst(auth()->user()->role->role_name) }}</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section-label">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-chart-pie"></i></div> Tableau de bord
        </a>
        <div class="nav-section-label">Gestion</div>
        <a href="{{ route('admin.students.index') }}" class="nav-item active">
            <div class="nav-icon"><i class="fas fa-user-graduate"></i></div> Élèves
        </a>
        <a href="{{ route('admin.teachers.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></div> Enseignants
        </a>
        <a href="{{ route('admin.classes.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-school"></i></div> Classes
        </a>
        <a href="{{ route('admin.subjects.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-book"></i></div> Matières
        </a>
        <div class="nav-section-label">Académique</div>
        <a href="{{ route('admin.grades.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-star"></i></div> Notes
        </a>
        <a href="{{ route('admin.attendances.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-calendar-check"></i></div> Absences
        </a>
        <a href="{{ route('admin.report-cards.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-file-alt"></i></div> Bulletins
        </a>
        <a href="{{ route('admin.schedules.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-clock"></i></div> Emploi du temps
        </a>
        <div class="nav-section-label">Finance</div>
        <a href="{{ route('admin.payments.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-money-bill-wave"></i></div> Paiements
        </a>
    </nav>
    <div class="sidebar-footer">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
        <button onclick="document.getElementById('logout-form').submit();" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </button>
    </div>
</aside>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div>
            <div class="topbar-title">Profil de l'Élève</div>
            <div class="topbar-subtitle">
                <a href="{{ route('admin.dashboard') }}">Accueil</a>
                <span style="margin:0 6px;">›</span>
                <a href="{{ route('admin.students.index') }}">Élèves</a>
                <span style="margin:0 6px;">›</span>
                <span style="color:var(--text);">{{ $student->first_name }} {{ $student->last_name }}</span>
            </div>
        </div>
        <div class="topbar-actions">
            <a href="{{ route('admin.students.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <a href="{{ route('admin.students.edit', $student) }}" class="btn-edit">
                <i class="fas fa-pen"></i> Modifier
            </a>
        </div>
    </div>

    <div class="content">

        {{-- EN-TÊTE PROFIL --}}
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($student->first_name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h1>{{ $student->first_name }} {{ $student->last_name }}</h1>
                <div class="reg"><i class="fas fa-id-card" style="margin-right:6px;"></i>{{ $student->registration_number }}</div>
                <span class="badge {{ $student->gender == 'M' ? 'badge-m' : 'badge-f' }}">
                    <i class="fas {{ $student->gender == 'M' ? 'fa-mars' : 'fa-venus' }}"></i>
                    {{ $student->gender == 'M' ? 'Masculin' : 'Féminin' }}
                </span>
            </div>
            <div class="profile-actions">
                <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                      onsubmit="return confirm('Supprimer cet élève ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>

        {{-- INFOS --}}
        <div class="info-grid">
            <div class="info-card">
                <div class="info-card-title"><i class="fas fa-user"></i> Informations personnelles</div>
                <div class="info-row">
                    <span class="info-label">Prénom</span>
                    <span class="info-value">{{ $student->first_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-value">{{ $student->last_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de naissance</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Genre</span>
                    <span class="info-value">{{ $student->gender == 'M' ? 'Masculin' : 'Féminin' }}</span>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-title"><i class="fas fa-school"></i> Informations scolaires</div>
                <div class="info-row">
                    <span class="info-label">N° d'inscription</span>
                    <span class="info-value">{{ $student->registration_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date d'inscription</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($student->created_at)->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Statut</span>
                    <span class="info-value" style="color:var(--accent2);">
                        <i class="fas fa-circle" style="font-size:8px; margin-right:4px;"></i> Actif
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>