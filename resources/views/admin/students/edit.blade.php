<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Modifier un Élève</title>
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
        .content { padding:32px; }

        /* FORM CARD */
        .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
        .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
        .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
        .form-title { font-size:16px; font-weight:600; }
        .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .form-body { padding:28px; }

        /* FORM ELEMENTS */
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
        .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
        .form-group:last-child { margin-bottom:0; }
        label { font-size:13px; font-weight:600; color:var(--text); }
        label span { color:var(--accent3); margin-left:2px; }
        input, select, textarea {
            background:var(--surface2); border:1px solid var(--border);
            border-radius:10px; padding:11px 16px; color:var(--text);
            font-size:14px; font-family:'DM Sans',sans-serif;
            transition:all 0.2s; outline:none; width:100%;
        }
        input:focus, select:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.1); }
        input::placeholder { color:var(--muted); }
        select option { background:var(--surface2); color:var(--text); }
        .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }

        /* BUTTONS */
        .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
        .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; }
        .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(245,158,11,0.3); }
        .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; }
        .btn-cancel:hover { color:var(--text); }

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
            <div class="topbar-title">Modifier l'Élève</div>
            <div class="topbar-subtitle">
                <a href="{{ route('admin.dashboard') }}">Accueil</a>
                <span style="margin:0 6px;">›</span>
                <a href="{{ route('admin.students.index') }}">Élèves</a>
                <span style="margin:0 6px;">›</span>
                <span style="color:var(--text);">Modifier</span>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="form-card">
            <div class="form-header">
                <div class="form-icon"><i class="fas fa-pen"></i></div>
                <div>
                    <div class="form-title">Modifier : {{ $student->first_name }} {{ $student->last_name }}</div>
                    <div class="form-subtitle">Modifiez les informations de l'élève</div>
                </div>
            </div>

            <div class="form-body">
                <form action="{{ route('admin.students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label>Prénom <span>*</span></label>
                            <input type="text" name="first_name"
                                   value="{{ old('first_name', $student->first_name) }}"
                                   placeholder="Ex: Kouadio">
                            @error('first_name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Nom <span>*</span></label>
                            <input type="text" name="last_name"
                                   value="{{ old('last_name', $student->last_name) }}"
                                   placeholder="Ex: Amani">
                            @error('last_name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Date de naissance <span>*</span></label>
                            <input type="date" name="date_of_birth"
                                   value="{{ old('date_of_birth', \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d')) }}">
                            @error('date_of_birth') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Genre <span>*</span></label>
                            <select name="gender">
                                <option value="">-- Choisir --</option>
                                <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('gender') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Numéro d'inscription <span>*</span></label>
                        <input type="text" name="registration_number"
                               value="{{ old('registration_number', $student->registration_number) }}"
                               placeholder="Ex: ELV-2024-001">
                        @error('registration_number') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                        <a href="{{ route('admin.students.show', $student) }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>