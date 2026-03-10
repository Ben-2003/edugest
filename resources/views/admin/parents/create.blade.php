@extends('layouts.admin')

@section('title', 'Nouveau Parent')
@section('page-title', 'Nouveau Parent')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.parents.index') }}">Parents</a> ›
    <span style="color:var(--text);">Ajouter</span>
@endsection

@section('styles')
<style>
    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
    .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,#6c63ff,#5a52d5); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .form-title { font-size:16px; font-weight:600; }
    .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
    .form-body { padding:28px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    .section-title { font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin:24px 0 16px; padding-bottom:8px; border-bottom:1px solid var(--border); }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus { border-color:#6c63ff; box-shadow:0 0 0 3px rgba(108,99,255,0.1); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }

    /* Checkboxes enfants */
    .students-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
    .student-check { display:flex; align-items:center; gap:10px; background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:12px 14px; cursor:pointer; transition:all 0.2s; }
    .student-check:hover { border-color:#6c63ff; }
    .student-check input[type="checkbox"] { width:16px; height:16px; accent-color:#6c63ff; cursor:pointer; }
    .student-check input[type="checkbox"]:checked ~ .student-info { color:var(--text); }
    .student-check:has(input:checked) { border-color:#6c63ff; background:rgba(108,99,255,0.08); }
    .student-info { font-size:13px; font-weight:500; }

    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,#6c63ff,#5a52d5); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; }
    .btn-cancel:hover { color:var(--text); }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-user-plus"></i></div>
        <div>
            <div class="form-title">Nouveau parent</div>
            <div class="form-subtitle">Créer un compte parent et lier ses enfants</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.parents.store') }}" method="POST">
            @csrf

            <div class="section-title">Informations personnelles</div>

            <div class="form-row">
                <div class="form-group">
                    <label>Prénom <span>*</span></label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Ex: Jean">
                    @error('first_name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Nom <span>*</span></label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Ex: Dupont">
                    @error('last_name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Ex: 06 00 00 00 00">
                    @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Adresse</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Ex: 12 rue des Fleurs">
                    @error('address') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="section-title">Compte de connexion</div>

            <div class="form-group">
                <label>Email <span>*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Ex: jean.dupont@email.com">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Mot de passe <span>*</span></label>
                    <input type="password" name="password" placeholder="Min. 8 caractères">
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Confirmer <span>*</span></label>
                    <input type="password" name="password_confirmation" placeholder="Répéter le mot de passe">
                </div>
            </div>

            <div class="section-title">Enfant(s) à lier <span style="color:var(--muted); font-weight:400; font-size:11px;">(optionnel)</span></div>

            @if($students->count() > 0)
            <div class="students-grid">
                @foreach($students as $student)
                <label class="student-check">
                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                           {{ in_array($student->id, old('student_ids', [])) ? 'checked' : '' }}>
                    <div class="student-info">
                        {{ $student->first_name }} {{ $student->last_name }}
                    </div>
                </label>
                @endforeach
            </div>
            @else
            <p style="color:var(--muted); font-size:13px;">Aucun élève enregistré pour l'instant.</p>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Créer le parent</button>
                <a href="{{ route('admin.parents.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection