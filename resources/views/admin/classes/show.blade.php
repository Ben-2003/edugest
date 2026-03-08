@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Détail Classe')
@section('page-title', 'Détail de la Classe')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.classes.index') }}">Classes</a> ›
    <span style="color:var(--text);">{{ $class->class_name }}</span>
@endsection

{{-- Boutons topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.classes.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
    <a href="{{ route('admin.classes.edit', $class) }}" class="btn-edit-top"><i class="fas fa-pen"></i> Modifier</a>
@endsection

@section('styles')
<style>
    /* En-tête profil */
    .profile-header { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:32px; display:flex; align-items:center; gap:24px; margin-bottom:24px; animation:fadeUp 0.3s ease both; }
    .class-avatar { width:80px; height:80px; border-radius:20px; background:linear-gradient(135deg,var(--accent),#5a52d5); display:flex; align-items:center; justify-content:center; font-size:32px; color:white; flex-shrink:0; }
    .profile-info h1 { font-size:22px; font-weight:700; margin-bottom:4px; }
    .profile-info .sub { font-size:13px; color:var(--muted); margin-bottom:12px; }
    .badge-level { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); }
    .profile-actions { margin-left:auto; }

    /* Grille infos */
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; animation:fadeUp 0.3s ease 0.1s both; }
    .info-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; }
    .info-card-title { font-size:13px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
    .info-card-title i { color:var(--accent); }
    .info-row { display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid var(--border); }
    .info-row:last-child { border-bottom:none; padding-bottom:0; }
    .info-label { font-size:13px; color:var(--muted); }
    .info-value { font-size:13px; font-weight:600; }
    .capacity-bar { margin-top:8px; }
    .capacity-label { display:flex; justify-content:space-between; font-size:12px; color:var(--muted); margin-bottom:6px; }
    .bar { height:8px; background:var(--surface2); border-radius:4px; overflow:hidden; }
    .bar-fill { height:100%; background:linear-gradient(90deg,var(--accent),var(--accent2)); border-radius:4px; }

    /* Tableau élèves */
    .students-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease 0.2s both; }
    .students-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
    .students-title { font-size:15px; font-weight:600; }
    .count-badge { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:12px 24px; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; text-align:left; border-bottom:1px solid var(--border); }
    tbody tr { border-bottom:1px solid var(--border); transition:background 0.15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:var(--surface2); }
    tbody td { padding:14px 24px; font-size:14px; }
    .s-avatar { width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:white; }
    .student-info { display:flex; align-items:center; gap:10px; }
    .badge-m { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.2); border-radius:20px; padding:3px 10px; font-size:11px; font-weight:600; }
    .badge-f { background:rgba(255,107,107,0.15); color:var(--accent3); border:1px solid rgba(255,107,107,0.2); border-radius:20px; padding:3px 10px; font-size:11px; font-weight:600; }
    .empty-state { padding:40px 24px; text-align:center; color:var(--muted); font-size:14px; }

    /* Bouton supprimer */
    .btn-delete { display:flex; align-items:center; gap:8px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-delete:hover { background:rgba(255,107,107,0.2); }
</style>
@endsection

@section('content')
{{-- En-tête --}}
<div class="profile-header">
    <div class="class-avatar"><i class="fas fa-door-open"></i></div>
    <div class="profile-info">
        <h1>{{ $class->class_name }}</h1>
        <div class="sub"><i class="fas fa-calendar" style="margin-right:6px;"></i>{{ $class->schoolYear ? $class->schoolYear->year_label : '—' }}</div>
        <span class="badge-level"><i class="fas fa-layer-group"></i> {{ $class->level }}</span>
    </div>
    <div class="profile-actions">
        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Supprimer</button>
        </form>
    </div>
</div>

{{-- Infos --}}
<div class="info-grid">
    <div class="info-card">
        <div class="info-card-title"><i class="fas fa-info-circle"></i> Informations</div>
        <div class="info-row"><span class="info-label">Nom</span><span class="info-value">{{ $class->class_name }}</span></div>
        <div class="info-row"><span class="info-label">Niveau</span><span class="info-value">{{ $class->level }}</span></div>
        <div class="info-row"><span class="info-label">Année scolaire</span><span class="info-value">{{ $class->schoolYear ? $class->schoolYear->year_label : '—' }}</span></div>
        <div class="info-row">
            <span class="info-label">Enseignant titulaire</span>
            <span class="info-value" style="color:var(--accent2);">{{ $class->teacher ? $class->teacher->first_name . ' ' . $class->teacher->last_name : 'Non assigné' }}</span>
        </div>
    </div>
    <div class="info-card">
        <div class="info-card-title"><i class="fas fa-users"></i> Effectif</div>
        @php
            $enrolled = $class->enrollments->count();
            $capacity = $class->capacity ?? 30;
            $pct = $capacity > 0 ? min(100, round($enrolled / $capacity * 100)) : 0;
        @endphp
        <div class="info-row"><span class="info-label">Élèves inscrits</span><span class="info-value" style="color:var(--accent);">{{ $enrolled }}</span></div>
        <div class="info-row"><span class="info-label">Capacité maximale</span><span class="info-value">{{ $capacity }}</span></div>
        <div class="info-row"><span class="info-label">Places disponibles</span><span class="info-value" style="color:var(--accent2);">{{ $capacity - $enrolled }}</span></div>
        <div class="capacity-bar">
            <div class="capacity-label"><span>Remplissage</span><span>{{ $pct }}%</span></div>
            <div class="bar"><div class="bar-fill" style="width:{{ $pct }}%"></div></div>
        </div>
    </div>
</div>

{{-- Liste des élèves --}}
<div class="students-card">
    <div class="students-header">
        <span class="students-title">Élèves de la classe</span>
        <span class="count-badge">{{ $enrolled }} élève(s)</span>
    </div>
    @if($class->enrollments->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>N° Inscription</th>
                <th>Genre</th>
                <th>Date de naissance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($class->enrollments as $enrollment)
            @if($enrollment->student)
            <tr>
                <td>
                    <div class="student-info">
                        <div class="s-avatar">{{ strtoupper(substr($enrollment->student->first_name, 0, 1)) }}</div>
                        <span>{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</span>
                    </div>
                </td>
                <td style="color:var(--muted);">{{ $enrollment->student->registration_number }}</td>
                <td><span class="{{ $enrollment->student->gender == 'M' ? 'badge-m' : 'badge-f' }}">{{ $enrollment->student->gender == 'M' ? 'Masculin' : 'Féminin' }}</span></td>
                <td style="color:var(--muted);">{{ \Carbon\Carbon::parse($enrollment->student->date_of_birth)->format('d/m/Y') }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class="fas fa-user-graduate" style="font-size:24px; margin-bottom:8px; display:block;"></i>
        Aucun élève inscrit dans cette classe
    </div>
    @endif
</div>
@endsection