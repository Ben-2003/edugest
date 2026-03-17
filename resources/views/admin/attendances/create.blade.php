@extends('layouts.admin')

@section('title', 'Enregistrer une Presence')
@section('page-title', 'Enregistrer une Presence')
@section('breadcrumb', 'Absences > Ajouter')

@section('styles')
<style>
    {{-- Selecteur visuel de statut avec 3 boutons radio --}}
    .status-selector { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .status-option { display:none; }
    .status-label { display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; border-radius:12px; border:2px solid #dee2e6; cursor:pointer; transition:all 0.2s; text-align:center; }
    .status-label:hover { border-color:#6c5ce7; background:#f8f9fa; }
    .status-label i { font-size:20px; }
    .status-label span { font-size:13px; font-weight:600; }
    {{-- Style actif selon le statut selectionne --}}
    .status-option:checked + .status-label.present-label { border-color:#00b894; background:rgba(0,184,148,0.1); color:#00b894; }
    .status-option:checked + .status-label.absent-label  { border-color:#e74c3c; background:rgba(231,76,60,0.1); color:#e74c3c; }
    .status-option:checked + .status-label.late-label    { border-color:#f59e0b; background:rgba(245,158,11,0.1); color:#f59e0b; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-calendar-check text-primary me-2"></i> Nouvelle presence
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Les champs marques <span class="text-danger">*</span> sont obligatoires
                    </small>
                </h4>

                <form action="{{ route('admin.attendances.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        {{-- Classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe <span class="text-danger">*</span></label>
                                <select name="class_id" id="class_id" class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                        @if(isset($class->level)) — {{ $class->level }} @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Eleve -- charge dynamiquement selon la classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eleve <span class="text-danger">*</span></label>
                                <select name="student_id" id="student_id" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir d'abord une classe --</option>
                                </select>
                                @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date <span class="text-danger">*</span></label>
                                <input type="date" name="attendance_date"
                                    class="form-control {{ $errors->has('attendance_date') ? 'is-invalid' : '' }}"
                                    value="{{ old('attendance_date', date('Y-m-d')) }}" required>
                                @error('attendance_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Selecteur visuel de statut --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Statut <span class="text-danger">*</span></label>
                                <div class="status-selector">

                                    {{-- Option : Present --}}
                                    <div>
                                        <input type="radio" name="status" id="present" value="present" class="status-option"
                                            {{ old('status', 'present') == 'present' ? 'checked' : '' }}>
                                        <label for="present" class="status-label present-label">
                                            <i class="mdi mdi-check-circle" style="color:#00b894;font-size:24px;"></i>
                                            <span>Present</span>
                                        </label>
                                    </div>

                                    {{-- Option : Absent --}}
                                    <div>
                                        <input type="radio" name="status" id="absent" value="absent" class="status-option"
                                            {{ old('status') == 'absent' ? 'checked' : '' }}>
                                        <label for="absent" class="status-label absent-label">
                                            <i class="mdi mdi-close-circle" style="color:#e74c3c;font-size:24px;"></i>
                                            <span>Absent</span>
                                        </label>
                                    </div>

                                    {{-- Option : Retard --}}
                                    <div>
                                        <input type="radio" name="status" id="late" value="late" class="status-option"
                                            {{ old('status') == 'late' ? 'checked' : '' }}>
                                        <label for="late" class="status-label late-label">
                                            <i class="mdi mdi-clock" style="color:#f59e0b;font-size:24px;"></i>
                                            <span>Retard</span>
                                        </label>
                                    </div>

                                </div>
                                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        {{-- Motif --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Motif / Observation</label>
                                <textarea name="reason" class="form-control" rows="3"
                                    placeholder="Raison de l'absence ou observation...">{{ old('reason') }}</textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> Enregistrer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
{{-- Chargement dynamique des eleves selon la classe selectionnee --}}
document.getElementById('class_id').addEventListener('change', function() {
    const classId = this.value;
    const studentSelect = document.getElementById('student_id');
    studentSelect.innerHTML = '<option value="">-- Chargement... --</option>';

    if (!classId) {
        studentSelect.innerHTML = '<option value="">-- Choisir d\'abord une classe --</option>';
        return;
    }

    fetch(`/api/classes/${classId}/students`)
        .then(res => res.json())
        .then(data => {
            studentSelect.innerHTML = '<option value="">-- Choisir un eleve --</option>';
            data.forEach(student => {
                studentSelect.innerHTML += `<option value="${student.id}">${student.last_name} ${student.first_name}</option>`;
            });
        })
        .catch(() => {
            studentSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
});
</script>
@endsection