{{-- ============================================================
     DASHBOARD ADMIN — EduGest
     Vue principale après connexion admin
     Hérite du layout commun layouts/admin.blade.php
     ============================================================ --}}
@extends('layouts.admin')

{{-- Titre de l'onglet navigateur --}}
@section('title', 'Tableau de Bord')

{{-- Titre affiché dans la topbar --}}
@section('page-title', 'Tableau de Bord')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <span style="color:var(--text);">Accueil</span>
@endsection

{{-- ============================================================
     STYLES SPÉCIFIQUES AU DASHBOARD
     Ces styles s'ajoutent aux styles globaux du layout
     ============================================================ --}}
@section('styles')
<style>
    /* ── Grille des 5 cartes statistiques ── */
/* ── Grille des 5 cartes statistiques ── */
/* ── Grille des 5 cartes statistiques ── */
.stats-grid {
    display:grid;
    grid-template-columns:repeat(5, 1fr); /* ← force exactement 5 colonnes */
    gap:20px;
    margin-bottom:32px;
}

    /* ── Carte statistique individuelle ── */
    .stat-card {
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:16px;
        padding:24px;
        display:flex;
        align-items:center;
        gap:16px;
        transition:all 0.2s;
        animation:fadeUp 0.3s ease both;
    }
    .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.2); }

    /* Icône colorée selon le module */
    .stat-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; color:white; flex-shrink:0; }
    .stat-icon.purple { background:linear-gradient(135deg,var(--accent),#5a52d5); }
    .stat-icon.green  { background:linear-gradient(135deg,var(--accent2),#00a884); }
    .stat-icon.orange { background:linear-gradient(135deg,#f59e0b,#d97706); }
    .stat-icon.red    { background:linear-gradient(135deg,#ff6b6b,#e05555); }
    .stat-icon.blue   { background:linear-gradient(135deg,#3b82f6,#2563eb); }

    /* Chiffre et libellé */
    .stat-number { font-size:28px; font-weight:700; line-height:1; margin-bottom:4px; }
    .stat-label  { font-size:13px; color:var(--muted); font-weight:500; }

    /* ── Titre de section ── */
    .section-title { font-size:16px; font-weight:700; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .section-title i { color:var(--accent); }

    /* ── Grille principale : graphique + activité récente ── */
    .main-grid {
        display:grid;
        grid-template-columns:2fr 1fr;
        gap:24px;
        margin-bottom:32px;
    }

    /* ── Carte graphique Chart.js ── */
    .chart-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; animation:fadeUp 0.3s ease 0.1s both; }
    .chart-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
    .chart-title  { font-size:15px; font-weight:600; }
    .chart-badge  { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }

    /* ── Carte activité récente ── */
    .activity-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; animation:fadeUp 0.3s ease 0.2s both; }
    .activity-item { display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid var(--border); }
    .activity-item:last-child { border-bottom:none; padding-bottom:0; }
    .activity-dot  { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; flex-shrink:0; }
    .dot-purple { background:rgba(108,99,255,0.15); color:var(--accent); }
    .activity-info { flex:1; }
    .activity-name { font-size:13px; font-weight:600; }
    .activity-sub  { font-size:12px; color:var(--muted); margin-top:2px; }
    .activity-time { font-size:11px; color:var(--muted); white-space:nowrap; }

    /* ── Grille secondaire : classes + raccourcis ── */
    .secondary-grid {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:24px;
    }

    /* ── Carte liste des classes ── */
    .classes-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; animation:fadeUp 0.3s ease 0.3s both; }
    .class-item { display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid var(--border); }
    .class-item:last-child { border-bottom:none; padding-bottom:0; }
    .class-name  { font-size:13px; font-weight:600; }
    .class-level { font-size:11px; color:var(--muted); margin-top:2px; }
    .class-count { font-size:12px; color:var(--accent2); font-weight:600; }

    /* ── Carte raccourcis rapides ── */
    .shortcuts-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; animation:fadeUp 0.3s ease 0.4s both; }
    .shortcut-btn { display:flex; align-items:center; gap:12px; padding:12px; border-radius:12px; text-decoration:none; color:var(--text); transition:all 0.2s; margin-bottom:8px; border:1px solid var(--border); }
    .shortcut-btn:last-child { margin-bottom:0; }
    .shortcut-btn:hover { background:var(--surface2); border-color:rgba(108,99,255,0.3); transform:translateX(4px); }
    .shortcut-icon  { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; }
    .shortcut-label { font-size:13px; font-weight:600; }
    .shortcut-sub   { font-size:11px; color:var(--muted); margin-top:1px; }
    .shortcut-arrow { margin-left:auto; color:var(--muted); font-size:12px; }
</style>
@endsection

{{-- ============================================================
     CONTENU PRINCIPAL DU DASHBOARD
     ============================================================ --}}
@section('content')

    {{-- ── SECTION 1 : Cartes statistiques ── --}}
    {{-- Affiche les compteurs globaux de chaque module --}}
    <div class="stats-grid">

        {{-- Carte : Élèves --}}
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-user-graduate"></i></div>
            <div>
                <div class="stat-number">{{ $totalStudents }}</div>
                <div class="stat-label">Élèves inscrits</div>
            </div>
        </div>

        {{-- Carte : Enseignants --}}
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="stat-number">{{ $totalTeachers }}</div>
                <div class="stat-label">Enseignants</div>
            </div>
        </div>

        {{-- Carte : Classes --}}
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-school"></i></div>
            <div>
                <div class="stat-number">{{ $totalClasses }}</div>
                <div class="stat-label">Classes actives</div>
            </div>
        </div>

        {{-- Carte : Matières --}}
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-book"></i></div>
            <div>
                <div class="stat-number">{{ $totalSubjects }}</div>
                <div class="stat-label">Matières</div>
            </div>
        </div>

        {{-- Carte : Inscriptions --}}
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-user-plus"></i></div>
            <div>
                <div class="stat-number">{{ $totalEnrollments }}</div>
                <div class="stat-label">Inscriptions</div>
            </div>
        </div>

    </div>

    {{-- ── SECTION 2 : Graphique + Activité récente ── --}}
    <div class="main-grid">

        {{-- Graphique en barres : nb d'élèves par classe (Chart.js) --}}
        <div class="chart-card">
            <div class="chart-header">
                <span class="chart-title">Élèves par classe</span>
                <span class="chart-badge">{{ $currentYear }}</span>
            </div>
            {{-- Canvas Chart.js — rempli par le script en bas de page --}}
            <canvas id="classChart" height="120"></canvas>
        </div>

        {{-- Liste des 5 derniers élèves ajoutés --}}
        <div class="activity-card">
            <div class="section-title"><i class="fas fa-clock"></i> Derniers élèves ajoutés</div>

            {{-- Boucle sur les élèves récents envoyés par le controller --}}
            @forelse($recentStudents as $student)
            <div class="activity-item">
                {{-- Avatar avec initiale du prénom --}}
                <div class="activity-dot dot-purple">
                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                </div>
                <div class="activity-info">
                    <div class="activity-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                    <div class="activity-sub">{{ $student->registration_number }}</div>
                </div>
                {{-- Temps relatif : "il y a 2 heures" --}}
                <div class="activity-time">
                    {{ \Carbon\Carbon::parse($student->created_at)->diffForHumans() }}
                </div>
            </div>
            @empty
            {{-- Message si aucun élève --}}
            <p style="color:var(--muted); font-size:13px; text-align:center; padding:20px 0;">
                Aucun élève récent
            </p>
            @endforelse
        </div>

    </div>

    {{-- ── SECTION 3 : Classes & Raccourcis ── --}}
    <div class="secondary-grid">

        {{-- Liste des classes avec leur effectif --}}
        <div class="classes-card">
            <div class="section-title"><i class="fas fa-school"></i> Classes & effectifs</div>

            @forelse($classes as $class)
            @php $count = $class->enrollments->count(); @endphp
            <div class="class-item">
                <div>
                    <div class="class-name">{{ $class->class_name }}</div>
                    <div class="class-level">{{ $class->level }}</div>
                </div>
                <div class="class-count">{{ $count }} élève(s)</div>
            </div>
            @empty
            <p style="color:var(--muted); font-size:13px; text-align:center; padding:20px 0;">
                Aucune classe
            </p>
            @endforelse
        </div>

        {{-- Boutons de raccourcis vers les actions fréquentes --}}
        <div class="shortcuts-card">
            <div class="section-title"><i class="fas fa-bolt"></i> Accès rapide</div>

            {{-- Raccourci : Ajouter un élève --}}
            <a href="{{ route('admin.students.create') }}" class="shortcut-btn">
                <div class="shortcut-icon" style="background:rgba(108,99,255,0.15); color:var(--accent);">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <div class="shortcut-label">Ajouter un élève</div>
                    <div class="shortcut-sub">Créer un nouveau profil</div>
                </div>
                <i class="fas fa-chevron-right shortcut-arrow"></i>
            </a>

            {{-- Raccourci : Ajouter un enseignant --}}
            <a href="{{ route('admin.teachers.create') }}" class="shortcut-btn">
                <div class="shortcut-icon" style="background:rgba(245,158,11,0.15); color:#f59e0b;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <div class="shortcut-label">Ajouter un enseignant</div>
                    <div class="shortcut-sub">Créer un compte enseignant</div>
                </div>
                <i class="fas fa-chevron-right shortcut-arrow"></i>
            </a>

            {{-- Raccourci : Inscrire un élève --}}
            <a href="{{ route('admin.enrollments.create') }}" class="shortcut-btn">
                <div class="shortcut-icon" style="background:rgba(0,212,170,0.15); color:var(--accent2);">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <div class="shortcut-label">Inscrire un élève</div>
                    <div class="shortcut-sub">Affecter à une classe</div>
                </div>
                <i class="fas fa-chevron-right shortcut-arrow"></i>
            </a>

            {{-- Raccourci : Créer une classe --}}
            <a href="{{ route('admin.classes.create') }}" class="shortcut-btn">
                <div class="shortcut-icon" style="background:rgba(59,130,246,0.15); color:#3b82f6;">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <div class="shortcut-label">Créer une classe</div>
                    <div class="shortcut-sub">Nouvelle classe scolaire</div>
                </div>
                <i class="fas fa-chevron-right shortcut-arrow"></i>
            </a>

        </div>
    </div>

@endsection

{{-- ============================================================
     SCRIPTS — Chart.js chargé depuis CDN
     Le graphique est initialisé avec les données du controller
     ============================================================ --}}
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    /* ── Initialisation du graphique en barres ──
       Les données viennent du DashboardController :
       - chartLabels : noms des classes (ex: ["CP-A", "CE1-B"])
       - chartData   : nb d'élèves par classe (ex: [25, 18]) */
    const ctx = document.getElementById('classChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Élèves',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(108,99,255,0.5)',
                borderColor: 'rgba(108,99,255,1)',
                borderWidth: 2,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: { color: '#7a7f9a' },
                    grid:  { color: 'rgba(255,255,255,0.05)' }
                },
                y: {
                    ticks: { color: '#7a7f9a', stepSize: 1 },
                    grid:  { color: 'rgba(255,255,255,0.05)' },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection