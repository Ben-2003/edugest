@extends('layouts.teacher')

@section('title', 'Mon Tableau de Bord')
@section('page-title', 'Tableau de Bord')

@section('breadcrumb')
    <span style="color:var(--text);">Accueil</span>
@endsection

@section('styles')
<style>
    /* ── Bannière de bienvenue ── */
    .welcome-banner { background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(59,130,246,0.1)); border:1px solid rgba(16,185,129,0.3); border-radius:16px; padding:24px 28px; margin-bottom:32px; display:flex; align-items:center; gap:20px; animation:fadeUp 0.3s ease both; }
    .welcome-avatar { width:56px; height:56px; border-radius:16px; background:linear-gradient(135deg,var(--accent),#059669); display:flex; align-items:center; justify-content:center; font-size:22px; font-weight:700; color:white; flex-shrink:0; }
    .welcome-title { font-size:20px; font-weight:700; }
    .welcome-sub   { font-size:13px; color:var(--muted); margin-top:3px; }

    /* ── Cartes statistiques ── */
    .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:32px; }
    .stat-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:20px; display:flex; align-items:center; gap:14px; animation:fadeUp 0.3s ease both; }
    .stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; color:white; flex-shrink:0; }
    .stat-icon.green  { background:linear-gradient(135deg,var(--accent),#059669); }
    .stat-icon.blue   { background:linear-gradient(135deg,var(--accent2),#2563eb); }
    .stat-icon.orange { background:linear-gradient(135deg,#f59e0b,#d97706); }
    .stat-icon.red    { background:linear-gradient(135deg,var(--accent3),#e05555); }
    .stat-number { font-size:26px; font-weight:700; line-height:1; }
    .stat-label  { font-size:12px; color:var(--muted); margin-top:3px; }

    /* ── Grille principale ── */
    .main-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }

    /* ── Carte générique ── */
    .card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .card-header { padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
    .card-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:14px; color:white; }
    .card-icon.green { background:linear-gradient(135deg,var(--accent),#059669); }
    .card-icon.blue  { background:linear-gradient(135deg,var(--accent2),#2563eb); }
    .card-title { font-size:14px; font-weight:600; }
    .card-body { padding:20px 24px; }

    /* ── Liste des classes ── */
    .class-item { display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid var(--border); }
    .class-item:last-child { border-bottom:none; }
    .class-dot { width:10px; height:10px; border-radius:50%; background:var(--accent); flex-shrink:0; }
    .class-name { font-size:14px; font-weight:600; flex:1; }
    .class-count { font-size:12px; color:var(--muted); background:var(--surface2); border:1px solid var(--border); border-radius:20px; padding:3px 10px; }

    /* ── Emploi du temps mini ── */
    .edt-day { margin-bottom:16px; }
    .edt-day-name { font-size:12px; font-weight:700; color:var(--accent); text-transform:uppercase; letter-spacing:1px; margin-bottom:8px; }
    .edt-slot { display:flex; align-items:center; gap:10px; background:var(--surface2); border-radius:10px; padding:10px 14px; margin-bottom:6px; }
    .edt-time { font-size:12px; font-weight:700; color:var(--accent2); min-width:90px; }
    .edt-subject { font-size:13px; font-weight:600; }
    .edt-class { font-size:11px; color:var(--muted); }

    /* ── Accès rapide ── */
    .quick-access { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:24px; }
    .quick-btn { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:14px 18px; text-decoration:none; color:var(--text); font-size:13px; font-weight:600; transition:all 0.2s; }
    .quick-btn:hover { border-color:var(--accent); background:rgba(16,185,129,0.05); color:var(--text); }
    .quick-btn i { font-size:16px; color:var(--accent); }
</style>
@endsection

@section('content')

{{-- ── Bannière de bienvenue ── --}}
<div class="welcome-banner">
    <div class="welcome-avatar">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}</div>
    <div>
        <div class="welcome-title">Bonjour, {{ $teacher->first_name }} {{ $teacher->last_name }} 👋</div>
        <div class="welcome-sub">
            {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }} —
            {{ $mesClasses->count() }} classe(s) assignée(s)
        </div>
    </div>
</div>

{{-- ── Statistiques personnelles ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-chalkboard"></i></div>
        <div>
            <div class="stat-number">{{ $mesClasses->count() }}</div>
            <div class="stat-label">Mes classes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
        <div>
            <div class="stat-number">{{ $totalEleves }}</div>
            <div class="stat-label">Mes élèves</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-star"></i></div>
        <div>
            <div class="stat-number">{{ $totalNotes }}</div>
            <div class="stat-label">Notes saisies</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
        <div>
            <div class="stat-number">{{ $totalAbsences }}</div>
            <div class="stat-label">Absences</div>
        </div>
    </div>
</div>

{{-- ── Grille principale ── --}}
<div class="main-grid">

    {{-- Mes classes --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon green"><i class="fas fa-chalkboard"></i></div>
            <span class="card-title">Mes classes</span>
        </div>
        <div class="card-body">
            @forelse($mesClasses as $classe)
            <div class="class-item">
                <div class="class-dot"></div>
                <span class="class-name">{{ $classe->class_name }} — {{ $classe->level }}</span>
                <span class="class-count">{{ $classe->enrollments->count() }} élève(s)</span>
            </div>
            @empty
            <p style="color:var(--muted); font-size:13px;">Aucune classe assignée</p>
            @endforelse
        </div>
    </div>

    {{-- Mon emploi du temps --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon blue"><i class="fas fa-clock"></i></div>
            <span class="card-title">Mon emploi du temps</span>
        </div>
        <div class="card-body">
            @forelse($monEmploiDuTemps as $jour => $slots)
            <div class="edt-day">
                <div class="edt-day-name">{{ $jour }}</div>
                @foreach($slots as $slot)
                <div class="edt-slot">
                    <span class="edt-time">
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                        — {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                    </span>
                    <div>
                        <div class="edt-subject">{{ $slot->subject->subject_name }}</div>
                        <div class="edt-class">{{ $slot->schoolClass->class_name }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @empty
            <p style="color:var(--muted); font-size:13px;">Aucun créneau enregistré</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ── Accès rapide ── --}}
<div class="quick-access">
    <a href="{{ route('teacher.grades.create') }}" class="quick-btn">
        <i class="fas fa-plus-circle"></i> Saisir une note
    </a>
    <a href="{{ route('teacher.attendances.create') }}" class="quick-btn">
        <i class="fas fa-clipboard-list"></i> Faire l'appel
    </a>
    <a href="{{ route('teacher.grades.index') }}" class="quick-btn">
        <i class="fas fa-list"></i> Voir toutes mes notes
    </a>
    <a href="{{ route('teacher.schedules') }}" class="quick-btn">
        <i class="fas fa-calendar"></i> Mon emploi du temps
    </a>
</div>

@endsection