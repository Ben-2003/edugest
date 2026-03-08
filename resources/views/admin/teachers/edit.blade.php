@extends('layouts.admin')

@section('title', 'Modifier Enseignant')
@section('page-title', 'Modifier l\'Enseignant')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.teachers.index') }}">Enseignants</a> ›
    <span style="color:var(--text);">Modifier</span>
@endsection

@section('styles')
<style>
    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
    .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .form-title { font-size:16px; font-weight:600; }
    .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
    .form-body { padding:28px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.1); }
    input::placeholder { color:var(--muted); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }
    .hint { font-size:11px; color:var(--muted); margin-top:4px; }
    .section-divider { font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; padding:16px 0 12px; border-top:1px solid var(--border); margin-top:8px; display:flex; align-items:center; gap:8px; }
    .section-divider i { color:var(--accent); }
    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(245,158,11,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { color:var(--text); }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-pen"></i></div>
        <div>
            <div class="form-title">Modifier : {{ $teacher->first_name }} {{ $teacher->last_name }}</div>
            <div class="form-subtitle">Modifiez les informations de l'enseignant</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label>Prénom <span>*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name) }}">
                    @error('first_name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Nom <span>*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name) }}">
                    @error('last_name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email <span>*</span></label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}">
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" placeholder="+225 07 00 00 00">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Spécialisation</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $teacher->specialization) }}">
                </div>
                <div class="form-group">
                    <label>Date d'embauche <span>*</span></label>
                    <input type="date" name="hire_date" value="{{ old('hire_date', $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('Y-m-d') : '') }}">
                    @error('hire_date') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="section-divider"><i class="fas fa-lock"></i> Changer le mot de passe (optionnel)</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="password" placeholder="Laisser vide pour ne pas changer">
                    <span class="hint">Minimum 8 caractères</span>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" placeholder="Répéter le nouveau mot de passe">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection