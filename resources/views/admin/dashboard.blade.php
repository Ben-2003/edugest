<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGest — Tableau de bord</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            --accent4: #ffc542;
            --sidebar-w: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            overflow-y: auto;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            padding: 0 0 24px 0;
        }

        .sidebar-logo {
            padding: 28px 24px 24px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo .logo-text {
            font-family: 'DM Serif Display', serif;
            font-size: 22px;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .sidebar-logo .logo-badge {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Avatar admin */
        .sidebar-user {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 15px;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-user .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .sidebar-user .user-role {
            font-size: 11px;
            color: var(--accent);
            font-weight: 500;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            padding: 12px 12px 6px;
            font-weight: 500;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: var(--surface2);
            color: var(--text);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(108,99,255,0.2), rgba(0,212,170,0.1));
            color: var(--text);
            border: 1px solid rgba(108,99,255,0.3);
        }

        .nav-item .nav-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            background: var(--surface2);
            flex-shrink: 0;
        }

        .nav-item.active .nav-icon {
            background: var(--accent);
            color: white;
        }

        /* Logout */
        .sidebar-footer {
            padding: 0 12px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--accent3);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            width: 100%;
            background: rgba(255,107,107,0.08);
            border: 1px solid rgba(255,107,107,0.15);
            cursor: pointer;
        }

        .logout-btn:hover {
            background: rgba(255,107,107,0.15);
        }

        /* ===== MAIN CONTENT ===== */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        .topbar {
            padding: 20px 32px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-subtitle {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-date {
            background: var(--surface2);
            border: 1px solid var(--border);
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            color: var(--muted);
        }

        .notif-btn {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--surface2);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }

        .notif-btn:hover { color: var(--text); border-color: var(--accent); }

        .notif-dot {
            width: 7px; height: 7px;
            background: var(--accent3);
            border-radius: 50%;
            position: absolute;
            top: 6px; right: 6px;
        }

        /* Content area */
        .content {
            padding: 32px;
            flex: 1;
        }

        /* ===== STAT CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255,255,255,0.12);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            filter: blur(30px);
            opacity: 0.3;
        }

        .stat-card.blue::before { background: #6c63ff; }
        .stat-card.green::before { background: #00d4aa; }
        .stat-card.orange::before { background: #ffc542; }
        .stat-card.red::before { background: #ff6b6b; }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
            letter-spacing: 0.3px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
            margin-bottom: 8px;
            font-family: 'DM Serif Display', serif;
        }

        .stat-change {
            font-size: 12px;
            color: var(--accent2);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-change.negative { color: var(--accent3); }

        .stat-icon {
            position: absolute;
            top: 20px; right: 20px;
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }

        .stat-card.blue .stat-icon { background: rgba(108,99,255,0.15); color: #6c63ff; }
        .stat-card.green .stat-icon { background: rgba(0,212,170,0.15); color: #00d4aa; }
        .stat-card.orange .stat-icon { background: rgba(255,197,66,0.15); color: #ffc542; }
        .stat-card.red .stat-icon { background: rgba(255,107,107,0.15); color: #ff6b6b; }

        /* ===== BOTTOM GRID ===== */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 4px;
        }

        .card-subtitle {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 20px;
        }

        /* Chart card */
        .chart-card {
            grid-column: span 2;
        }

        /* Students list */
        .student-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .student-item:last-child { border-bottom: none; }

        .student-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .student-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
        }

        .student-id {
            font-size: 11px;
            color: var(--muted);
        }

        /* ===== 3ème LIGNE — Stats supplémentaires ===== */
        .third-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .mini-stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s;
        }

        .mini-stat:hover { transform: translateY(-2px); }

        .mini-stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .mini-stat-value {
            font-size: 22px;
            font-weight: 700;
            font-family: 'DM Serif Display', serif;
        }

        .mini-stat-label {
            font-size: 12px;
            color: var(--muted);
        }

        /* Alert message */
        .alert-success-custom {
            background: rgba(0,212,170,0.1);
            border: 1px solid rgba(0,212,170,0.3);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 24px;
            color: var(--accent2);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--surface); }
        ::-webkit-scrollbar-thumb { background: var(--surface2); border-radius: 4px; }

        /* Animation d'entrée */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stat-card { animation: fadeUp 0.4s ease both; }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }
        .card { animation: fadeUp 0.4s ease 0.25s both; }
        .mini-stat { animation: fadeUp 0.4s ease 0.35s both; }

        /* ===== SEARCH BAR ===== */
.search-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 8px 14px;
    width: 280px;
    transition: all 0.2s;
}

.search-bar:focus-within {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(108,99,255,0.1);
}

.search-icon {
    color: var(--muted);
    font-size: 13px;
    flex-shrink: 0;
}

.search-bar input {
    background: none;
    border: none;
    outline: none;
    color: var(--text);
    font-size: 13px;
    width: 100%;
    font-family: 'DM Sans', sans-serif;
}

.search-bar input::placeholder { color: var(--muted); }

.search-bar kbd {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 4px;
    padding: 2px 6px;
    font-size: 10px;
    color: var(--muted);
    flex-shrink: 0;
}

/* ===== PROFILE MENU ===== */
.profile-menu {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 6px 12px 6px 6px;
    cursor: pointer;
    position: relative;
    transition: all 0.2s;
}

.profile-menu:hover {
    border-color: rgba(255,255,255,0.15);
}

.profile-avatar {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    font-weight: 700;
    color: white;
}

.profile-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
}

.profile-role {
    font-size: 11px;
    color: var(--accent);
}

/* Dropdown profil */
.profile-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 220px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    z-index: 999;
    overflow: hidden;
    animation: fadeUp 0.2s ease;
}

.profile-dropdown.open { display: block; }

.dropdown-header {
    padding: 14px 16px;
}

.dropdown-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
}

.dropdown-email {
    font-size: 12px;
    color: var(--muted);
    margin-top: 2px;
}

.dropdown-divider {
    height: 1px;
    background: var(--border);
}

.dropdown-item-custom {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    font-size: 13px;
    color: var(--muted);
    text-decoration: none;
    transition: all 0.15s;
}

.dropdown-item-custom:hover {
    background: var(--surface2);
    color: var(--text);
}

.dropdown-item-custom.text-danger { color: #ff6b6b !important; }
.dropdown-item-custom.text-danger:hover { background: rgba(255,107,107,0.1); }
    </style>
</head>
<body>

{{-- ========== SIDEBAR ========== --}}
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

        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <div class="nav-icon"><i class="fas fa-chart-pie"></i></div>
            Tableau de bord
        </a>

        <div class="nav-section-label">Gestion</div>

        <a href="{{ route('admin.students.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-user-graduate"></i></div>
            Élèves
        </a>

        <a href="{{ route('admin.teachers.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            Enseignants
        </a>

        <a href="{{ route('admin.classes.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-school"></i></div>
            Classes
        </a>

        <a href="{{ route('admin.subjects.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-book"></i></div>
            Matières
        </a>

        <div class="nav-section-label">Académique</div>

        <a href="{{ route('admin.grades.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-star"></i></div>
            Notes
        </a>

        <a href="{{ route('admin.attendances.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-calendar-check"></i></div>
            Absences
        </a>

        <a href="{{ route('admin.report-cards.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-file-alt"></i></div>
            Bulletins
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-clock"></i></div>
            Emploi du temps
        </a>

        <div class="nav-section-label">Finance</div>

        <a href="{{ route('admin.payments.index') }}" class="nav-item">
            <div class="nav-icon"><i class="fas fa-money-bill-wave"></i></div>
            Paiements
        </a>
    </nav>

    <div class="sidebar-footer">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
        <button onclick="document.getElementById('logout-form').submit();" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            Déconnexion
        </button>
    </div>
</aside>

{{-- ========== MAIN ========== --}}
<div class="main">

    {{-- Topbar --}}
   <div class="topbar">
    <div>
        <div class="topbar-title">Tableau de bord</div>
        <div class="topbar-subtitle">Bienvenue, {{ auth()->user()->first_name }} 👋 — voici un aperçu de l'école</div>
    </div>
    <div class="topbar-right">

        {{-- Barre de recherche --}}
        <div class="search-bar">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="Rechercher un élève, enseignant..." id="searchInput">
            <kbd>⌘K</kbd>
        </div>

        {{-- Date --}}
        <div class="topbar-date">
            <i class="fas fa-calendar me-1"></i>
            {{ now()->format('d/m/Y') }}
        </div>

        {{-- Notification --}}
        <div class="notif-btn">
            <i class="fas fa-bell" style="font-size:14px;"></i>
            <div class="notif-dot"></div>
        </div>

        {{-- Menu profil --}}
        <div class="profile-menu" onclick="toggleProfile()">
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                <div class="profile-role">{{ ucfirst(auth()->user()->role->role_name) }}</div>
            </div>
            <i class="fas fa-chevron-down" style="font-size:11px; color:var(--muted); margin-left:4px;"></i>

            {{-- Dropdown --}}
            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="dropdown-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                    <div class="dropdown-email">{{ auth()->user()->email }}</div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item-custom">
                    <i class="fas fa-user"></i> Mon profil
                </a>
                <a href="#" class="dropdown-item-custom">
                    <i class="fas fa-cog"></i> Paramètres
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item-custom text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>

    </div>
</div>

    <div class="content">

        {{-- Message succès --}}
        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ===== CARTES STATS ===== --}}
        <div class="stats-grid">

            <div class="stat-card blue">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-label">Total Élèves</div>
                <div class="stat-value">{{ $totalStudents }}</div>
                <div class="stat-change"><i class="fas fa-arrow-up"></i> Inscrits</div>
            </div>

            <div class="stat-card green">
                <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stat-label">Enseignants</div>
                <div class="stat-value">{{ $totalTeachers }}</div>
                <div class="stat-change"><i class="fas fa-arrow-up"></i> Actifs</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-icon"><i class="fas fa-school"></i></div>
                <div class="stat-label">Classes</div>
                <div class="stat-value">{{ $totalClasses }}</div>
                <div class="stat-change"><i class="fas fa-arrow-up"></i> Ouvertes</div>
            </div>

            <div class="stat-card red">
                <div class="stat-icon"><i class="fas fa-calendar-times"></i></div>
                <div class="stat-label">Absences aujourd'hui</div>
                <div class="stat-value">{{ $todayAbsences }}</div>
                <div class="stat-change negative"><i class="fas fa-exclamation-circle"></i> Aujourd'hui</div>
            </div>

        </div>

        {{-- ===== GRAPHIQUE + ÉLÈVES ===== --}}
        <div class="bottom-grid">

            {{-- Graphique --}}
            <div class="card chart-card">
                <div class="card-title">Paiements mensuels</div>
                <div class="card-subtitle">Aperçu des 6 derniers mois en FCFA</div>
                <canvas id="paymentChart" height="80"></canvas>
            </div>

            {{-- Derniers élèves --}}
            <div class="card">
                <div class="card-title">Derniers élèves</div>
                <div class="card-subtitle">Nouvelles inscriptions</div>

                @forelse($recentStudents as $student)
                    <div class="student-item">
                        <div class="student-avatar">
                            {{ strtoupper(substr($student->first_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="student-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                            <div class="student-id">{{ $student->registration_number }}</div>
                        </div>
                    </div>
                @empty
                    <p style="color:var(--muted); font-size:13px; text-align:center; margin-top:20px;">
                        Aucun élève inscrit
                    </p>
                @endforelse
            </div>

        </div>

        {{-- ===== 3ème LIGNE ===== --}}
        <div class="third-grid">

            <div class="mini-stat">
                <div class="mini-stat-icon" style="background:rgba(108,99,255,0.15); color:#6c63ff;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div>
                    <div class="mini-stat-value" style="color:#6c63ff;">
                        {{ number_format($totalPayments, 0, ',', '.') }}
                    </div>
                    <div class="mini-stat-label">FCFA reçus</div>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon" style="background:rgba(0,212,170,0.15); color:#00d4aa;">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <div class="mini-stat-value" style="color:#00d4aa;">{{ $totalEnrollments }}</div>
                    <div class="mini-stat-label">Inscriptions totales</div>
                </div>
            </div>

            <div class="mini-stat">
                <div class="mini-stat-icon" style="background:rgba(255,197,66,0.15); color:#ffc542;">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <div class="mini-stat-value" style="color:#ffc542;">{{ $totalReportCards }}</div>
                    <div class="mini-stat-label">Bulletins générés</div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // Graphique des paiements
    const ctx = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Oct', 'Nov', 'Déc', 'Jan', 'Fév', 'Mar'],
            datasets: [{
                label: 'Paiements',
                data: [0, 0, 0, 0, 0, 0],
                borderColor: '#6c63ff',
                backgroundColor: 'rgba(108,99,255,0.08)',
                borderWidth: 2.5,
                pointBackgroundColor: '#6c63ff',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: { color: '#7a7f9a', font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: { color: '#7a7f9a', font: { size: 11 } }
                }
            }
        }
    });

    <script>
    // Toggle menu profil
    function toggleProfile() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('open');
    }

    // Fermer le dropdown si on clique ailleurs
    document.addEventListener('click', function(e) {
        const menu = document.querySelector('.profile-menu');
        if (!menu.contains(e.target)) {
            document.getElementById('profileDropdown').classList.remove('open');
        }
    });
</script>
</script>

</body>
</html>