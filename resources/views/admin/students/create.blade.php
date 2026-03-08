@extends('layouts.admin')

@section('title', 'Ajouter un Élève')
@section('page-title', 'Ajouter un Élève')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.students.index') }}">Élèves</a> ›
    <span style="color:var(--text);">Ajouter</span>
@endsection

@section('styles')
<style>
    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
    .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,var(--accent),#5a52d5); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .form-title { font-size:16px; font-weight:600; }
    .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
    .form-body { padding:28px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(108,99,255,0.1); }
    input::placeholder { color:var(--muted); }
    select option { background:var(--surface2); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }
    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { color:var(--text); }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-user-graduate"></i></div>
        <div>
            <div class="form-title">Nouvel élève</div>
            <div class="form-subtitle">Remplissez les informations de l'élève</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.students.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Prénom <span>*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Ex: Kouadio">
                    @error('first_name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Nom <span>*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Ex: Amani">
                    @error('last_name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Date de naissance <span>*</span></label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Genre <span>*</span></label>
                    <select name="gender">
                        <option value="">-- Choisir --</option>
                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('gender') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Numéro d'inscription <span>*</span></label>
                <input type="text" name="registration_number" value="{{ old('registration_number') }}" placeholder="Ex: ELV-2024-001">
                @error('registration_number') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer l'élève</button>
                <a href="{{ route('admin.students.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection