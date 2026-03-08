@extends('layouts.admin')

@section('title', 'Profil Élève')
@section('page-title', 'Profil de l\'Élève')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.students.index') }}">Élèves</a> ›
    <span style="color:var(--text);">{{ $student->first_name }} {{ $student->last_name }}</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.students.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
    <a href="{{ route('admin.students.edit', $student) }}" class="btn-edit"><i class="fas fa-pen"></i> Modifier</a>
@endsection

@section('styles')
<style>
    .profile-header { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:32px; display:flex; align-items:center; gap:24px; margin-bottom:24px; animation:fadeUp 0.3s ease both; }
    .profile-avatar { width:80px; height:80px; border-radius:20px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:700; color:white; flex-shrink:0; }
    .profile-info h1 { font-size:22px; font-weight:700; margin-bottom:4px; }
    .profile-info .reg { font-size:13px; color:var(--muted); margin-bottom:12px; }
    .badge { display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600; }
    .badge-m { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); }
    .badge-f { background:rgba(255,107,107,0.15); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); }
    .profile-actions { margin-left:auto; display:flex; gap:10px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; animation:fadeUp 0.3s ease 0.1s both; }
    .info-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; }
    .info-card-title { font-size:13px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:20px; display:flex; align-items:center; gap:8px; }
    .info-card-title i { color:var(--accent); }
    .info-row { display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid var(--border); }
    .info-row:last-child { border-bottom:none; padding-bottom:0; }
    .info-label { font-size:13px; color:var(--muted); }
    .info-value { font-size:13px; font-weight:600; }
    .btn-edit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-edit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
    .btn-back { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-back:hover { color:var(--text); }
    .btn-delete { display:flex; align-items:center; gap:8px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-delete:hover { background:rgba(255,107,107,0.2); }
</style>
@endsection

@section('content')
<div class="profile-header">
    <div class="profile-avatar">{{ strtoupper(substr($student->first_name, 0, 1)) }}</div>
    <div class="profile-info">
        <h1>{{ $student->first_name }} {{ $student->last_name }}</h1>
        <div class="reg"><i class="fas fa-id-card" style="margin-right:6px;"></i>{{ $student->registration_number }}</div>
        <span class="badge {{ $student->gender == 'M' ? 'badge-m' : 'badge-f' }}">
            <i class="fas {{ $student->gender == 'M' ? 'fa-mars' : 'fa-venus' }}"></i>
            {{ $student->gender == 'M' ? 'Masculin' : 'Féminin' }}
        </span>
    </div>
    <div class="profile-actions">
        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Supprimer cet élève ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Supprimer</button>
        </form>
    </div>
</div>

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
@endsection