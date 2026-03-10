@extends('layouts.teacher')

@section('title', 'Saisir une Note')
@section('page-title', 'Saisir une Note')

@section('breadcrumb')
    <a href="{{ route('teacher.dashboard') }}">Accueil</a> ›
    <a href="{{ route('teacher.grades.index') }}">Notes</a> ›
    <span style="color:var(--text);">Saisir</span>
@endsection

@section('styles')
<style>
    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
    .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,var(--accent),#059669); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .form-title { font-size:16px; font-weight:600; }
    .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
    .form-body { padding:28px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
    .form-group { display:flex; flex-direction:column; gap:8px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
    select option { background:var(--surface2); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }
    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#059669); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(16,185,129,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { color:var(--text); }

    /* Info box */
    .info-box { background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.25); border-radius:12px; padding:14px 18px; margin-bottom:24px; font-size:13px; color:var(--accent); display:flex; align-items:center; gap:10px; }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-star"></i></div>
        <div>
            <div class="form-title">Saisir une note</div>
            <div class="form-subtitle">Limitée à vos classes uniquement</div>
        </div>
    </div>
    <div class="form-body">

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            Vous ne pouvez saisir des notes que pour vos classes assignées.
        </div>

        <form action="{{ route('teacher.grades.store') }}" method="POST">
            @csrf

            {{-- Classe --}}
            <div class="form-group" style="margin-bottom:20px;">
                <label>Ma classe <span>*</span></label>
                <select name="class_id" id="classSelect">
                    <option value="">-- Choisir une classe --</option>
                    @foreach($mesClasses as $classe)
                        <option value="{{ $classe->id }}"
                            data-class="{{ $classe->id }}"
                            {{ old('class_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->class_name }} — {{ $classe->level }}
                        </option>
                    @endforeach
                </select>
                @error('class_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Élève et Matière --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Élève <span>*</span></label>
                    <select name="student_id" id="studentSelect">
                        <option value="">-- Choisir d'abord une classe --</option>
                    </select>
                    @error('student_id') <span class="error-msg">{{ $message }}</span> @enderror
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

            {{-- Année scolaire et Trimestre --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Année scolaire <span>*</span></label>
                    <select name="school_year_id">
                        <option value="">-- Choisir une année --</option>
                        @foreach(\App\Models\SchoolYear::orderBy('start_date','desc')->get() as $year)
                            <option value="{{ $year->id }}" {{ old('school_year_id') == $year->id ? 'selected' : '' }}>
                                {{ $year->year_label }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_year_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Trimestre <span>*</span></label>
                    <select name="term">
                        <option value="">-- Choisir --</option>
                        <option value="Trimestre 1" {{ old('term') == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                        <option value="Trimestre 2" {{ old('term') == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                        <option value="Trimestre 3" {{ old('term') == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                    </select>
                    @error('term') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Note --}}
            <div class="form-group" style="margin-bottom:20px;">
                <label>Note (sur 20) <span>*</span></label>
                <input type="number" name="score" min="0" max="20" step="0.25"
                       value="{{ old('score') }}" placeholder="Ex: 14.5">
                @error('score') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer la note</button>
                <a href="{{ route('teacher.grades.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /* Chargement dynamique des élèves selon la classe sélectionnée */
    document.getElementById('classSelect').addEventListener('change', function() {
        const classId = this.value;
        const studentSelect = document.getElementById('studentSelect');

        studentSelect.innerHTML = '<option value="">Chargement...</option>';

        if (!classId) {
            studentSelect.innerHTML = '<option value="">-- Choisir d\'abord une classe --</option>';
            return;
        }

        fetch(`/api/classes/${classId}/students`)
            .then(r => r.json())
            .then(students => {
                studentSelect.innerHTML = '<option value="">-- Choisir un élève --</option>';
                students.forEach(s => {
                    studentSelect.innerHTML += `<option value="${s.id}">${s.first_name} ${s.last_name}</option>`;
                });
            })
            .catch(() => {
                studentSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    });
</script>
@endsection