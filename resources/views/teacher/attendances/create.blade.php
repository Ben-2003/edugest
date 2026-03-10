@extends('layouts.teacher')

@section('title', 'Faire l\'Appel')
@section('page-title', 'Faire l\'Appel')

@section('breadcrumb')
    <a href="{{ route('teacher.dashboard') }}">Accueil</a> ›
    <a href="{{ route('teacher.attendances.index') }}">Absences</a> ›
    <span style="color:var(--text);">Appel</span>
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
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(16,185,129,0.1); }
    select option { background:var(--surface2); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }

    /* Statut radio buttons */
    .status-options { display:flex; gap:12px; }
    .status-option { flex:1; }
    .status-option input[type="radio"] { display:none; }
    .status-option label { display:flex; align-items:center; justify-content:center; gap:8px; padding:12px; border:2px solid var(--border); border-radius:12px; cursor:pointer; transition:all 0.2s; font-size:13px; font-weight:600; width:100%; }
    .status-option input[type="radio"]:checked + label.present { border-color:var(--accent); background:rgba(16,185,129,0.1); color:var(--accent); }
    .status-option input[type="radio"]:checked + label.absent  { border-color:var(--accent3); background:rgba(255,107,107,0.1); color:var(--accent3); }
    .status-option input[type="radio"]:checked + label.late    { border-color:#f59e0b; background:rgba(245,158,11,0.1); color:#f59e0b; }
    .status-option label:hover { border-color:var(--accent); }

    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#059669); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(16,185,129,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { color:var(--text); }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-clipboard-list"></i></div>
        <div>
            <div class="form-title">Faire l'appel</div>
            <div class="form-subtitle">Enregistrer la présence d'un élève</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('teacher.attendances.store') }}" method="POST">
            @csrf

            {{-- Classe et Date --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Ma classe <span>*</span></label>
                    <select name="class_id" id="classSelect">
                        <option value="">-- Choisir une classe --</option>
                        @foreach($mesClasses as $classe)
                            <option value="{{ $classe->id }}" {{ old('class_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->class_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Date <span>*</span></label>
                    <input type="date" name="attendance_date"
                           value="{{ old('attendance_date', date('Y-m-d')) }}">
                    @error('attendance_date') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Élève --}}
            <div class="form-group">
                <label>Élève <span>*</span></label>
                <select name="student_id" id="studentSelect">
                    <option value="">-- Choisir d'abord une classe --</option>
                </select>
                @error('student_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Statut --}}
            <div class="form-group">
                <label>Statut <span>*</span></label>
                <div class="status-options">
                    <div class="status-option">
                        <input type="radio" name="status" id="present" value="present"
                               {{ old('status', 'present') === 'present' ? 'checked' : '' }}>
                        <label for="present" class="present">
                            <i class="fas fa-check-circle"></i> Présent
                        </label>
                    </div>
                    <div class="status-option">
                        <input type="radio" name="status" id="absent" value="absent"
                               {{ old('status') === 'absent' ? 'checked' : '' }}>
                        <label for="absent" class="absent">
                            <i class="fas fa-times-circle"></i> Absent
                        </label>
                    </div>
                    <div class="status-option">
                        <input type="radio" name="status" id="late" value="late"
                               {{ old('status') === 'late' ? 'checked' : '' }}>
                        <label for="late" class="late">
                            <i class="fas fa-clock"></i> En retard
                        </label>
                    </div>
                </div>
                @error('status') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="{{ route('teacher.attendances.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /* Chargement dynamique des élèves selon la classe */
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
                if (students.length === 0) {
                    studentSelect.innerHTML = '<option value="">Aucun élève inscrit</option>';
                    return;
                }
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