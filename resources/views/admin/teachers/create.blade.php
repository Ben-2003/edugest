<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Ajouter un Enseignant</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --bg:#0f1117; --surface:#1a1d27; --surface2:#22263a; --border:rgba(255,255,255,0.07); --text:#f0f0f5; --muted:#7a7f9a; --accent:#6c63ff; --accent2:#00d4aa; --accent3:#ff6b6b; --sidebar-w:260px; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'DM Sans',sans-serif; }
        body { background:var(--bg); color:var(--text); display:flex; min-height:100vh; }
        .sidebar { width:var(--sidebar-w); height:100vh; background:var(--surface); border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; top:0; left:0; overflow-y:auto; }
        .sidebar-logo { padding:28px 24px 24px; border-bottom:1px solid var(--border); }
        .logo-text { font-family:'DM Serif Display',serif; font-size:22px; }
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
        .logout-btn { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--accent3); font-size:14px; font-weight:600; background:rgba(255,107,107,0.08); border:1px solid rgba(255,107,107,0.15); cursor:pointer; width:100%; }
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; }
        .topbar { padding:20px 32px; border-bottom:1px solid var(--border); background:var(--surface); position:sticky; top:0; z-index:50; }
        .topbar-title { font-size:18px; font-weight:600; }
        .topbar-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .topbar-subtitle a { color:var(--muted); text-decoration:none; }
        .content { padding:32px; }
        .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
        .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
        .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,var(--accent),#5a52d5); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
        .form-title { font-size:16px; font-weight:600; }
        .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .form-body { padding:28px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
        .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
        label { font-size:13px; font-weight:600; }
        label span { color:var(--accent3); }
        input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
        input:focus, select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(108,99,255,0.1); }
        input::placeholder { color:var(--muted); }
        select option { background:var(--surface2); }
        .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }
        .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
        .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
        .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
        .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
        .btn-cancel:hover { color:var(--text); }
        @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-chart-pie"></i></div> Tableau de bord</a>
        <div class="nav-section-label">Gestion</div>
        <a href="{{ route('admin.students.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-user-graduate"></i></div> Élèves</a>
        <a href="{{ route('admin.teachers.index') }}" class="nav-item active"><div class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></div> Enseignants</a>
        <a href="{{ route('admin.classes.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-school"></i></div> Classes</a>
        <a href="{{ route('admin.subjects.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-book"></i></div> Matières</a>
        <div class="nav-section-label">Académique</div>
        <a href="{{ route('admin.grades.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-star"></i></div> Notes</a>
        <a href="{{ route('admin.attendances.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-calendar-check"></i></div> Absences</a>
        <a href="{{ route('admin.report-cards.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-file-alt"></i></div> Bulletins</a>
        <a href="{{ route('admin.schedules.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-clock"></i></div> Emploi du temps</a>
        <div class="nav-section-label">Finance</div>
        <a href="{{ route('admin.payments.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-money-bill-wave"></i></div> Paiements</a>
    </nav>
    <div class="sidebar-footer">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
        <button onclick="document.getElementById('logout-form').submit();" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar-title">Ajouter un Enseignant</div>
        <div class="topbar-subtitle">
            <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
            <a href="{{ route('admin.teachers.index') }}">Enseignants</a> › Ajouter
        </div>
    </div>
    <div class="content">
        <div class="form-card">
            <div class="form-header">
                <div class="form-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div>
                    <div class="form-title">Nouvel enseignant</div>
                    <div class="form-subtitle">Remplissez les informations de l'enseignant</div>
                </div>
            </div>
            <div class="form-body">
                <form action="{{ route('admin.teachers.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prénom <span>*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Ex: Konan">
                            @error('first_name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Nom <span>*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Ex: Yao">
                            @error('last_name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email <span>*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="enseignant@ecole.ci">
                            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Ex: +225 07 00 00 00">
                            @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Spécialisation</label>
                            <input type="text" name="specialization" value="{{ old('specialization') }}" placeholder="Ex: Mathématiques">
                            @error('specialization') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Date d'embauche <span>*</span></label>
                            <input type="date" name="hire_date" value="{{ old('hire_date') }}">
                            @error('hire_date') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer</button>
                        <a href="{{ route('admin.teachers.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>