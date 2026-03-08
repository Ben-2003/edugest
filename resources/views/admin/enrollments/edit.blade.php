@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Modifier Inscription')
@section('page-title', 'Modifier l\'Inscription')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.enrollments.index') }}">Inscriptions</a> ›
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
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.1); }
    select option { background:var(--surface2); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }
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
            <div class="form-title">
                Modifier : {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}
            </div>
            <div class="form-subtitle">Modifier la classe ou la date d'inscription</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Élève <span>*</span></label>
                <select name="student_id">
                    <option value="">-- Choisir un élève --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}"
                            {{ old('student_id', $enrollment->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->last_name }} {{ $student->first_name }} — {{ $student->registration_number }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Classe <span>*</span></label>
                <select name="class_id">
                    <option value="">-- Choisir une classe --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ old('class_id', $enrollment->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }} — {{ $class->level }}
                            {{ $class->schoolYear ? '(' . $class->schoolYear->year_label . ')' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Date d'inscription <span>*</span></label>
                <input type="date" name="enrollment_date"
                       value="{{ old('enrollment_date', \Carbon\Carbon::parse($enrollment->enrollment_date)->format('Y-m-d')) }}">
                @error('enrollment_date') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                <a href="{{ route('admin.enrollments.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection