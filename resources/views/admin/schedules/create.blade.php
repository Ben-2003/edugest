@extends('layouts.admin')

@section('title', 'Nouveau Créneau')
@section('page-title', 'Nouveau Créneau')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.schedules.index') }}">Emploi du temps</a> ›
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
        <div class="form-icon"><i class="fas fa-calendar-plus"></i></div>
        <div>
            <div class="form-title">Nouveau créneau</div>
            <div class="form-subtitle">Ajouter un cours à l'emploi du temps</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf

            {{-- Classe et matière --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Classe <span>*</span></label>
                    <select name="class_id">
                        <option value="">-- Choisir une classe --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }} — {{ $class->level }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Matière <span>*</span></label>
                    <select name="subject_id">
                        <option value="">-- Choisir une matière --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Enseignant et jour --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Enseignant <span>*</span></label>
                    <select name="teacher_id">
                        <option value="">-- Choisir un enseignant --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Jour <span>*</span></label>
                    <select name="day_of_week">
                        <option value="">-- Choisir un jour --</option>
                        @foreach($jours as $jour)
                            <option value="{{ $jour }}" {{ old('day_of_week') == $jour ? 'selected' : '' }}>
                                {{ $jour }}
                            </option>
                        @endforeach
                    </select>
                    @error('day_of_week') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Heure début et fin --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Heure de début <span>*</span></label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}">
                    @error('start_time') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Heure de fin <span>*</span></label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}">
                    @error('end_time') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer le créneau</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection