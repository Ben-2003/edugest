@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Ajouter une Matière')
@section('page-title', 'Ajouter une Matière')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.subjects.index') }}">Matières</a> ›
    <span style="color:var(--text);">Ajouter</span>
@endsection

@section('styles')
<style>
    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
    .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,var(--accent2),#00a884); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .form-title { font-size:16px; font-weight:600; }
    .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
    .form-body { padding:28px; }
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, textarea { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, textarea:focus { border-color:var(--accent2); box-shadow:0 0 0 3px rgba(0,212,170,0.1); }
    input::placeholder, textarea::placeholder { color:var(--muted); }
    textarea { resize:vertical; min-height:100px; }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }
    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent2),#00a884); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(0,212,170,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { color:var(--text); }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-book-open"></i></div>
        <div>
            <div class="form-title">Nouvelle matière</div>
            <div class="form-subtitle">Remplissez les informations de la matière</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.subjects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nom de la matière <span>*</span></label>
                <input type="text" name="subject_name" value="{{ old('subject_name') }}"
                       placeholder="Ex: Mathématiques, Français, Sciences...">
                @error('subject_name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            {{-- Champ coefficient requis par la migration --}}
        <div class="form-group">
            <label>Coefficient <span>*</span></label>
            <input type="number" name="coefficient" value="{{ old('coefficient', 1) }}"
                min="1" max="10" placeholder="Ex: 2">
            @error('coefficient') <span class="error-msg">{{ $message }}</span> @enderror
        </div>      
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Description optionnelle de la matière...">{{ old('description') }}</textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Créer la matière</button>
                <a href="{{ route('admin.subjects.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection