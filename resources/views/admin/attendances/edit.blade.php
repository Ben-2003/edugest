@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Modifier une Présence')
@section('page-title', 'Modifier la Présence')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.attendances.index') }}">Absences</a> ›
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
    input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.1); }
    select option { background:var(--surface2); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }
    .status-selector { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .status-option { display:none; }
    .status-label { display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; border-radius:12px; border:2px solid var(--border); cursor:pointer; transition:all 0.2s; text-align:center; }
    .status-label:hover { border-color:#f59e0b; background:var(--surface2); }
    .status-label i { font-size:20px; }
    .status-label span { font-size:13px; font-weight:600; }
    .status-option:checked + .status-label.present-label { border-color:var(--accent2); background:rgba(0,212,170,0.1); color:var(--accent2); }
    .status-option:checked + .status-label.absent-label  { border-color:var(--accent3); background:rgba(255,107,107,0.1); color:var(--accent3); }
    .status-option:checked + .status-label.late-label    { border-color:#f59e0b; background:rgba(245,158,11,0.1); color:#f59e0b; }
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
                Modifier : {{ $attendance->student->first_name }} {{ $attendance->student->last_name }}
            </div>
            <div class="form-subtitle">
                {{ $attendance->schoolClass->class_name }} —
                {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d/m/Y') }}
            </div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.attendances.update', $attendance) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>Élève <span>*</span></label>
                    <select name="student_id">
                        <option value="">-- Choisir un élève --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}"
                                {{ old('student_id', $attendance->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->last_name }} {{ $student->first_name }}
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
                                {{ old('class_id', $attendance->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }} — {{ $class->level }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Date <span>*</span></label>
                <input type="date" name="attendance_date"
                       value="{{ old('attendance_date', \Carbon\Carbon::parse($attendance->attendance_date)->format('Y-m-d')) }}">
                @error('attendance_date') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Sélecteur visuel de statut avec valeur pré-sélectionnée --}}
            <div class="form-group">
                <label>Statut <span>*</span></label>
                <div class="status-selector">
                    <div>
                        <input type="radio" name="status" id="present" value="present" class="status-option"
                               {{ old('status', $attendance->status) == 'present' ? 'checked' : '' }}>
                        <label for="present" class="status-label present-label">
                            <i class="fas fa-check-circle" style="color:var(--accent2);"></i>
                            <span>Présent</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="absent" value="absent" class="status-option"
                               {{ old('status', $attendance->status) == 'absent' ? 'checked' : '' }}>
                        <label for="absent" class="status-label absent-label">
                            <i class="fas fa-times-circle" style="color:var(--accent3);"></i>
                            <span>Absent</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="late" value="late" class="status-option"
                               {{ old('status', $attendance->status) == 'late' ? 'checked' : '' }}>
                        <label for="late" class="status-label late-label">
                            <i class="fas fa-clock" style="color:#f59e0b;"></i>
                            <span>Retard</span>
                        </label>
                    </div>
                </div>
                @error('status') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                <a href="{{ route('admin.attendances.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection