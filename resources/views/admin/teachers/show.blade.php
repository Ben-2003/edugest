@extends('layouts.admin')

@section('title', 'Profil Enseignant')
@section('page-title', 'Profil Enseignant')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.teachers.index') }}">Enseignants</a> ›
    <span style="color:var(--text);">{{ $teacher->first_name }} {{ $teacher->last_name }}</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.teachers.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn-edit"><i class="fas fa-pen"></i> Modifier</a>
@endsection

@section('styles')
<style>
    .profile-header { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:32px; display:flex; align-items:center; gap:24px; margin-bottom:24px; animation:fadeUp 0.3s ease both; }
    .profile-avatar { width:80px; height:80px; border-radius:20px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:700; color:white; flex-shrink:0; }
    .profile-info h1 { font-size:22px; font-weight:700; margin-bottom:4px; }
    .profile-info .sub { font-size:13px; color:var(--muted); margin-bottom:12px; }
    .badge-spec { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; background:rgba(0,212,170,0.15); color:var(--accent2); border:1px solid rgba(0,212,170,0.3); }
    .profile-actions { margin-left:auto; display:flex; gap:10px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; animation:fadeUp 0.3s ease 0.1s both; }
    .info-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; }
    .info-card-title { font-size:13px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
    .info-card-title i { color:var(--accent); }
    .info-row { display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid var(--border); }
    .info-row:last-child { border-bottom:none; padding-bottom:0; }
    .info-label { font-size:13px; color:var(--muted); }
    .info-value { font-size:13px; font-weight:600; }
    .btn-edit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-edit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(245,158,11,0.3); }
    .btn-back { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-back:hover { color:var(--text); }
    .btn-delete { display:flex; align-items:center; gap:8px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-delete:hover { background:rgba(255,107,107,0.2); }
</style>
@endsection

@section('content')
<div class="profile-header">
    <div class="profile-avatar">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}</div>
    <div class="profile-info">
        <h1>{{ $teacher->first_name }} {{ $teacher->last_name }}</h1>
        <div class="sub"><i class="fas fa-envelope" style="margin-right:6px;"></i>{{ $teacher->email ?? '—' }}</div>
        @if($teacher->specialization)
            <span class="badge-spec"><i class="fas fa-graduation-cap"></i> {{ $teacher->specialization }}</span>
        @endif
    </div>
    <div class="profile-actions">
        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Supprimer cet enseignant ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Supprimer</button>
        </form>
    </div>
</div>

<div class="info-grid">
    <div class="info-card">
        <div class="info-card-title"><i class="fas fa-user"></i> Informations personnelles</div>
        <div class="info-row"><span class="info-label">Prénom</span><span class="info-value">{{ $teacher->first_name }}</span></div>
        <div class="info-row"><span class="info-label">Nom</span><span class="info-value">{{ $teacher->last_name }}</span></div>
        <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $teacher->email ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Téléphone</span><span class="info-value">{{ $teacher->phone ?? '—' }}</span></div>
    </div>
    <div class="info-card">
        <div class="info-card-title"><i class="fas fa-briefcase"></i> Informations professionnelles</div>
        <div class="info-row"><span class="info-label">Spécialisation</span><span class="info-value" style="color:var(--accent2);">{{ $teacher->specialization ?? '—' }}</span></div>
        <div class="info-row"><span class="info-label">Date d'embauche</span><span class="info-value">{{ $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('d/m/Y') : '—' }}</span></div>
        <div class="info-row">
            <span class="info-label">Compte utilisateur</span>
            <span class="info-value" style="color:var(--accent2);">
                <i class="fas fa-circle" style="font-size:8px; margin-right:4px;"></i>
                {{ $teacher->user ? 'Actif' : 'Aucun compte' }}
            </span>
        </div>
        <div class="info-row"><span class="info-label">Ajouté le</span><span class="info-value">{{ \Carbon\Carbon::parse($teacher->created_at)->format('d/m/Y') }}</span></div>
    </div>
</div>
@endsection