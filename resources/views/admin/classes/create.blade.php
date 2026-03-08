@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Ajouter une Classe')
@section('page-title', 'Ajouter une Classe')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.classes.index') }}">Classes</a> ›
    <span style="color:var(--text);">Ajouter</span>
@endsection

@section('styles')
<style>
    /* Carte formulaire */
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
        <div class="form-icon"><i class="fas fa-school"></i></div>
        <div>
            <div class="form-title">Nouvelle classe</div>
            <div class="form-subtitle">Remplissez les informations de la classe</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.classes.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Nom de la classe <span>*</span></label>
                    <input type="text" name="class_name" value="{{ old('class_name') }}" placeholder="Ex: CP-A">
                    @error('class_name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Niveau <span>*</span></label>
                    <select name="level">
                        <option value="">-- Choisir un niveau --</option>
                        <optgroup label="Maternelle">
                            @foreach(['Petite Section','Moyenne Section','Grande Section'] as $lvl)
                                <option value="{{ $lvl }}" {{ old('level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Primaire">
                            @foreach(['CP','CE1','CE2','CM1','CM2'] as $lvl)
                                <option value="{{ $lvl }}" {{ old('level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('level') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Année scolaire <span>*</span></label>
                    <input type="text" name="year_label" value="{{ old('year_label', '2025-2026') }}" placeholder="Ex: 2025-2026">
                    @error('year_label') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Capacité maximale <span>*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', 30) }}" min="1" max="100">
                    @error('capacity') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Enseignant titulaire</label>
                <select name="teacher_id">
                    <option value="">-- Aucun titulaire --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                            {{ $teacher->specialization ? '— ' . $teacher->specialization : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Créer la classe</button>
                <a href="{{ route('admin.classes.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection