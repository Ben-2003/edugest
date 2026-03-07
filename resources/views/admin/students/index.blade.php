<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Gestion des Élèves</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bg: #0f1117;
            --surface: #1a1d27;
            --surface2: #22263a;
            --border: rgba(255,255,255,0.07);
            --text: #f0f0f5;
            --muted: #7a7f9a;
            --accent: #6c63ff;
            --accent2: #00d4aa;
            --accent3: #ff6b6b;
            --sidebar-w: 260px;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'DM Sans',sans-serif; }
        body { background: var(--bg); color: var(--text); display:flex; min-height:100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top:0; left:0;
            overflow-y: auto;
        }
        .sidebar-logo {
            padding: 28px 24px 24px;
            border-bottom: 1px solid var(--border);
        }
        .logo-text { font-family:'DM Serif Display',serif; font-size:22px; color:var(--text); }
        .logo-badge { font-size:10px; color:var(--muted); letter-spacing:2px; text-transform:uppercase; }
        .sidebar-user {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display:flex; align-items:center; gap:12px;
        }
        .avatar {
            width:40px; height:40px; border-radius:12px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display:flex; align-items:center; justify-content:center;
            font-weight:700; font-size:15px; color:white; flex-shrink:0;
        }
        .user-name { font-size:14px; font-weight:600; }
        .user-role { font-size:11px; color:var(--accent); }
        .sidebar-nav { flex:1; padding:16px 12px; }
        .nav-section-label {
            font-size:10px; letter-spacing:2px; text-transform:uppercase;
            color:var(--muted); padding:12px 12px 6px; font-weight:500;
        }
        .nav-item {
            display:flex; align-items:center; gap:10px;
            padding:10px 12px; border-radius:10px;
            color:var(--muted); text-decoration:none;
            font-size:14px; font-weight:500;
            transition:all 0.2s; margin-bottom:2px;
        }
        .nav-item:hover { background:var(--surface2); color:var(--text); }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(108,99,255,0.2), rgba(0,212,170,0.1));
            color:var(--text); border:1px solid rgba(108,99,255,0.3);
        }
        .nav-icon {
            width:32px; height:32px; border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            font-size:13px; background:var(--surface2); flex-shrink:0;
        }
        .nav-item.active .nav-icon { background:var(--accent); color:white; }
        .sidebar-footer { padding:16px 12px; }
        .logout-btn {
            display:flex; align-items:center; gap:10px;
            padding:10px 12px; border-radius:10px;
            color:var(--accent3); text-decoration:none;
            font-size:14px; font-weight:500;
            background:rgba(255,107,107,0.08);
            border:1px solid rgba(255,107,107,0.15);
            cursor:pointer; width:100%;
        }

        /* MAIN */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; }
        .topbar {
            padding:20px 32px;
            border-bottom:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between;
            background:var(--surface);
            position:sticky; top:0; z-index:50;
        }
        .topbar-title { font-size:18px; font-weight:600; }
        .topbar-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .content { padding:32px; }

        /* TOOLBAR */
        .toolbar {
            display:flex; align-items:center;
            justify-content:space-between;
            margin-bottom:24px;
        }
        .search-input {
            display:flex; align-items:center; gap:8px;
            background:var(--surface); border:1px solid var(--border);
            border-radius:10px; padding:10px 16px; width:300px;
        }
        .search-input input {
            background:none; border:none; outline:none;
            color:var(--text); font-size:13px; width:100%;
            font-family:'DM Sans',sans-serif;
        }
        .search-input input::placeholder { color:var(--muted); }
        .btn-add {
            display:flex; align-items:center; gap:8px;
            background: linear-gradient(135deg, var(--accent), #5a52d5);
            color:white; border:none; border-radius:10px;
            padding:10px 20px; font-size:14px; font-weight:600;
            cursor:pointer; text-decoration:none;
            transition:all 0.2s;
        }
        .btn-add:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }

        /* TABLE */
        .table-card {
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:16px;
            overflow:hidden;
        }
        .table-header {
            padding:20px 24px;
            border-bottom:1px solid var(--border);
            display:flex; align-items:center; justify-content:space-between;
        }
        .table-title { font-size:15px; font-weight:600; }
        .table-count {
            background:rgba(108,99,255,0.1);
            border:1px solid rgba(108,99,255,0.2);
            color:var(--accent);
            padding:4px 12px; border-radius:20px;
            font-size:12px; font-weight:600;
        }
        table { width:100%; border-collapse:collapse; }
        thead tr { border-bottom:1px solid var(--border); }
        thead th {
            padding:14px 24px;
            text-align:left;
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:1px;
            color:var(--muted);
            font-weight:600;
        }
        tbody tr {
            border-bottom:1px solid var(--border);
            transition:background 0.15s;
        }
        tbody tr:last-child { border-bottom:none; }
        tbody tr:hover { background:var(--surface2); }
        tbody td { padding:16px 24px; font-size:14px; }

        .student-cell { display:flex; align-items:center; gap:12px; }
        .student-av {
            width:36px; height:36px; border-radius:10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display:flex; align-items:center; justify-content:center;
            font-size:13px; font-weight:700; color:white; flex-shrink:0;
        }
        .student-name { font-weight:600; font-size:14px; }
        .student-id { font-size:11px; color:var(--muted); }

        .badge-gender {
            padding:4px 10px; border-radius:6px;
            font-size:11px; font-weight:600;
        }
        .badge-m { background:rgba(108,99,255,0.1); color:var(--accent); }
        .badge-f { background:rgba(255,107,107,0.1); color:var(--accent3); }

        .actions { display:flex; align-items:center; gap:8px; }
        .btn-action {
            width:32px; height:32px; border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            border:none; cursor:pointer; font-size:13px;
            text-decoration:none; transition:all 0.2s;
        }
        .btn-view { background:rgba(0,212,170,0.1); color:var(--accent2); }
        .btn-edit { background:rgba(255,197,66,0.1); color:#ffc542; }
        .btn-delete { background:rgba(255,107,107,0.1); color:var(--accent3); }
        .btn-action:hover { transform:scale(1.1); }

        /* Empty state */
        .empty-state {
            text-align:center; padding:60px 24px;
        }
        .empty-icon {
            width:64px; height:64px; border-radius:16px;
            background:rgba(108,99,255,0.1);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 16px; font-size:28px; color:var(--accent);
        }
        .empty-title { font-size:16px; font-weight:600; margin-bottom:8px; }
        .empty-text { font-size:13px; color:var(--muted); }

        /* Alert */
        .alert-success {
            background:rgba(0,212,170,0.1);
            border:1px solid rgba(0,212,170,0.3);
            border-radius:12px; padding:14px 18px;
            margin-bottom:24px; color:var(--accent2);
            font-size:14px; display:flex; align-items:center; gap:10px;
        }

        /* Pagination */
        .pagination-wrapper { padding:16px 24px; border-top:1px solid var(--border); }
        .pagination { display:flex; gap:6px; }
        .page-link {
            padding:6px 12px; border-radius:8px;
            background:var(--surface2); border:1px solid var(--border);
            color:var(--muted); font-size:13px; text-decoration:none;
            transition:all 0.2s;
        }
        .page-link:hover, .page-link.active {
            background:var(--accent); color:white; border-color:var(--accent);
        }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(12px); }
            to { opacity:1; transform:translateY(0); }
        }
        .table-card { animation:fadeUp 0.3s ease both; }
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
            <div class="topbar-title">Gestion des Élèves</div>
            <div class="topbar-subtitle">
                <a href="{{ route('admin.dashboard') }}" style="color:var(--muted); text-decoration:none;">Accueil</a>
                <span style="margin:0 6px; color:var(--muted);">›</span>
                <span style="color:var(--text);">Élèves</span>
            </div>
        </div>
    </div>

    <div class="content">

        {{-- Succès --}}
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Toolbar --}}
        <div class="toolbar">
            <div class="search-input">
                <i class="fas fa-search" style="color:var(--muted); font-size:13px;"></i>
                <input type="text" placeholder="Rechercher un élève..." id="searchInput" onkeyup="searchStudents()">
            </div>
            <a href="{{ route('admin.students.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> Ajouter un élève
            </a>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <div class="table-header">
                <span class="table-title">Liste des élèves</span>
                <span class="table-count">{{ $students->total() }} élèves</span>
            </div>

            @if($students->count() > 0)
                <table id="studentsTable">
                    <thead>
                        <tr>
                            <th>Élève</th>
                            <th>Date de naissance</th>
                            <th>Genre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    <div class="student-cell">
                                        <div class="student-av">
                                            {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="student-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                                            <div class="student-id">{{ $student->registration_number }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="color:var(--muted);">
                                    {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <span class="badge-gender {{ $student->gender === 'M' ? 'badge-m' : 'badge-f' }}">
                                        {{ $student->gender === 'M' ? '👦 Masculin' : '👧 Féminin' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.students.show', $student->id) }}" class="btn-action btn-view" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn-action btn-edit" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                              onsubmit="return confirm('Supprimer cet élève ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="pagination-wrapper">
                    <div class="pagination">
                        {{ $students->links() }}
                    </div>
                </div>

            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="empty-title">Aucun élève inscrit</div>
                    <div class="empty-text">Commencez par ajouter votre premier élève</div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Recherche en temps réel
    function searchStudents() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#studentsTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    }
</script>

</body>
</html>