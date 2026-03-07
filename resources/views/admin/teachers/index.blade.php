<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Enseignants</title>
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
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; }
        .topbar { padding:20px 32px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--surface); position:sticky; top:0; z-index:50; }
        .topbar-title { font-size:18px; font-weight:600; }
        .topbar-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .topbar-subtitle a { color:var(--muted); text-decoration:none; }
        .content { padding:32px; }
        .toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; gap:16px; }
        .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; flex:1; max-width:400px; }
        .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
        .search-box input::placeholder { color:var(--muted); }
        .btn-add { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:11px 20px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; white-space:nowrap; }
        .btn-add:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
        .alert-success { background:rgba(0,212,170,0.1); border:1px solid rgba(0,212,170,0.3); color:var(--accent2); border-radius:12px; padding:14px 20px; margin-bottom:24px; display:flex; align-items:center; gap:10px; font-size:14px; font-weight:500; animation:fadeUp 0.3s ease both; }
        .table-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
        .table-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .table-title { font-size:15px; font-weight:600; }
        .count-badge { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
        table { width:100%; border-collapse:collapse; }
        thead th { padding:12px 24px; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; text-align:left; border-bottom:1px solid var(--border); }
        tbody tr { border-bottom:1px solid var(--border); transition:background 0.15s; }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:var(--surface2); }
        tbody td { padding:16px 24px; font-size:14px; vertical-align:middle; }
        .teacher-info { display:flex; align-items:center; gap:12px; }
        .t-avatar { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; color:white; flex-shrink:0; }
        .t-name { font-weight:600; font-size:14px; }
        .t-email { font-size:12px; color:var(--muted); margin-top:2px; }
        .spec-badge { display:inline-flex; align-items:center; gap:5px; background:rgba(0,212,170,0.1); color:var(--accent2); border:1px solid rgba(0,212,170,0.2); border-radius:20px; padding:4px 10px; font-size:12px; font-weight:500; }
        .actions { display:flex; gap:6px; }
        .btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:13px; transition:all 0.2s; text-decoration:none; }
        .btn-view { background:rgba(0,212,170,0.1); color:var(--accent2); }
        .btn-view:hover { background:rgba(0,212,170,0.2); }
        .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
        .btn-edit:hover { background:rgba(245,158,11,0.2); }
        .btn-del { background:rgba(255,107,107,0.1); color:var(--accent3); }
        .btn-del:hover { background:rgba(255,107,107,0.2); }
        .empty-state { padding:60px 24px; text-align:center; }
        .empty-icon { width:64px; height:64px; border-radius:16px; background:var(--surface2); display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px; }
        .empty-title { font-size:16px; font-weight:600; margin-bottom:8px; }
        .empty-text { font-size:14px; color:var(--muted); }
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
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-chart-pie"></i></div> Tableau de bord
        </a>
        <div class="nav-section-label">Gestion</div>
        <a href="{{ route('admin.students.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-user-graduate"></i></div> Élèves
        </a>
        <a href="{{ route('admin.teachers.index') }}" class="nav-item active">
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

<div class="main">
    <div class="topbar">
        <div>
            <div class="topbar-title">Gestion des Enseignants</div>
            <div class="topbar-subtitle">
                <a href="{{ route('admin.dashboard') }}">Accueil</a>
                <span style="margin:0 6px;">›</span>
                <span style="color:var(--text);">Enseignants</span>
            </div>
        </div>
    </div>

    <div class="content">

        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="toolbar">
            <div class="search-box">
                <i class="fas fa-search" style="color:var(--muted);"></i>
                <input type="text" id="searchInput" placeholder="Rechercher un enseignant...">
            </div>
            <a href="{{ route('admin.teachers.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Ajouter un enseignant
            </a>
        </div>

        <div class="table-card">
            <div class="table-header">
                <span class="table-title">Liste des enseignants</span>
                <span class="count-badge">{{ $teachers->total() }} enseignant(s)</span>
            </div>

            @if($teachers->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Enseignant</th>
                        <th>Téléphone</th>
                        <th>Spécialisation</th>
                        <th>Date d'embauche</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="teacherTable">
                    @foreach($teachers as $teacher)
                    <tr>
                        <td>
                            <div class="teacher-info">
                                <div class="t-avatar">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}</div>
                                <div>
                                    <div class="t-name">{{ $teacher->first_name }} {{ $teacher->last_name }}</div>
                                    <div class="t-email">{{ $teacher->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--muted);">{{ $teacher->phone ?? '—' }}</td>
                        <td>
                            @if($teacher->specialization)
                                <span class="spec-badge">
                                    <i class="fas fa-graduation-cap"></i>
                                    {{ $teacher->specialization }}
                                </span>
                            @else
                                <span style="color:var(--muted);">—</span>
                            @endif
                        </td>
                        <td style="color:var(--muted);">
                            {{ \Carbon\Carbon::parse($teacher->hire_date)->format('d/m/Y') }}
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn-icon btn-view" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn-icon btn-edit" title="Modifier">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cet enseignant ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon btn-del" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:16px 24px; border-top:1px solid var(--border);">
                {{ $teachers->links() }}
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="empty-title">Aucun enseignant inscrit</div>
                <div class="empty-text">Commencez par ajouter votre premier enseignant</div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#teacherTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
</body>
</html>