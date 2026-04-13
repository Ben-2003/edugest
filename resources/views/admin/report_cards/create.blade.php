@extends('layouts.admin')

@section('title', 'Nouveau Bulletin')
@section('page-title', 'Nouveau Bulletin')
@section('breadcrumb', 'Bulletins > Nouveau')

@section('styles')
<style>
    /* {{-- Tableau de saisie des notes --}} */
    .notes-table th { background:#2c3e50; color:#fff; padding:8px 10px; font-size:12px; }
    .notes-table td { padding:6px 10px; vertical-align:middle; }
    .notes-table tr:nth-child(even) { background:#f8f9fa; }

    /* {{-- Input note --}} */
    .score-input { width:80px; text-align:center; font-weight:700; font-size:14px; }
    .score-input:focus { border-color:#6c5ce7; box-shadow:0 0 0 2px rgba(108,92,231,0.2); }
/* 
    {{-- Badge coefficient --}} */
    .coeff-badge { display:inline-block; background:#e9ecef; border-radius:4px; padding:2px 8px; font-size:12px; font-weight:600; }

    /* {{-- Preview moyenne --}} */
    .moyenne-preview { font-size:28px; font-weight:700; color:#6c5ce7; }
    .moyenne-mention { font-size:13px; font-weight:600; margin-top:4px; }
    <style>
/* Forcer même taille que les select */
.same-size {
    height: calc(2.25rem + 2px); /* même que Bootstrap select */
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

/* Optionnel si ton thème modifie les select */
select.form-control {
    height: calc(2.25rem + 2px);
}
</style>
</style>
@endsection

@section('content')
<form action="{{ route('admin.report_cards.store') }}" method="POST" id="bulletinForm">
@csrf

<div class="row">

    {{-- SECTION 1 : Infos generales --}}
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-file-document text-primary me-2"></i> Informations generales
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Choisissez la classe, l'eleve et le trimestre
                    </small>
                </h4>

                <div class="row">
                    {{-- Classe --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Classe <span class="text-danger">*</span></label>
                            <select name="class_id" id="class_id" class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" required>
                                <option value="">-- Choisir --</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Eleve -- charge dynamiquement selon la classe --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Eleve <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" required>
                                <option value="">-- Choisir d'abord une classe --</option>
                            </select>
                            @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Annee scolaire --}}
<div class="col-md-3">
    <div class="form-group">
        <label>Année scolaire <span class="text-danger">*</span></label>

        <input type="text"
               name="school_year"
               list="schoolYearsList"
               class="form-control same-size {{ $errors->has('school_year') ? 'is-invalid' : '' }}"
               placeholder="Ex: 2025-2026"
               value="{{ old('school_year') }}"
               required>

        <datalist id="schoolYearsList">
            @foreach($schoolYears as $year)
                <option value="{{ $year->year_name }}">
            @endforeach
        </datalist>

        @error('school_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>      

                    {{-- Trimestre --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Trimestre <span class="text-danger">*</span></label>
                            <select name="term" class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" required>
                                <option value="">-- Choisir --</option>
                                <option value="Trimestre 1" {{ old('term') == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                                <option value="Trimestre 2" {{ old('term') == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                                <option value="Trimestre 3" {{ old('term') == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                            </select>
                            @error('term')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 2 : Saisie des notes --}}
    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-star text-warning me-2"></i> Saisie des notes
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Saisissez la note de chaque matiere sur 20
                    </small>
                </h4>

                <div class="table-responsive">
                    <table class="table table-bordered notes-table">
                        <thead>
                            <tr>
                                <th style="width:40%;">Matiere</th>
                                <th style="width:15%;">Coefficient</th>
                                <th style="width:20%;">Note /20</th>
                                <th style="width:25%;">Note x Coeff</th>
                            </tr>
                        </thead>
                        <tbody id="notesTableBody">
                            @foreach($subjects as $subject)
                            <tr id="row_{{ $subject->id }}">
                                <td>
                                    <strong>{{ $subject->subject_name }}</strong>
                                    <input type="hidden" name="subject_ids[]" value="{{ $subject->id }}">
                                </td>
                                <td class="text-center">
                                    <span class="coeff-badge">{{ $subject->coefficient ?? 1 }}</span>
                                </td>
                                <td>
                                    {{-- Input de saisie de la note --}}
                                    <input type="number"
                                        name="scores[{{ $subject->id }}]"
                                        id="score_{{ $subject->id }}"
                                        class="form-control score-input"
                                        min="0" max="20" step="0.5"
                                        placeholder="—"
                                        value="{{ old('scores.' . $subject->id) }}"
                                        data-coeff="{{ $subject->coefficient ?? 1 }}"
                                        oninput="updateCalculs()">
                                </td>
                                <td class="text-center" id="points_{{ $subject->id }}">
                                    <span class="text-muted">—</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:#2c3e50;color:#fff;">
                                <td><strong>TOTAL</strong></td>
                                <td class="text-center" id="totalCoeff"><strong>0</strong></td>
                                <td class="text-center"><strong>—</strong></td>
                                <td class="text-center" id="totalPoints"><strong>0</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 3 : Preview moyenne + infos complementaires --}}
    <div class="col-md-4 grid-margin">

        {{-- Preview moyenne --}}
        <div class="card mb-3">
            <div class="card-body text-center">
                <h5 class="card-title">Moyenne calculee</h5>
                <div class="moyenne-preview" id="moyennePreview">—</div>
                <div class="moyenne-mention" id="mentionPreview"></div>
                <hr>
                <small class="text-muted">Calculee automatiquement</small>
            </div>
        </div>

        {{-- Rang et appreciation --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Informations complementaires</h5>

                {{-- Rang --}}
                <div class="form-group">
                    <label>Rang dans la classe</label>
                    <input type="number" name="rank" class="form-control"
                        value="{{ old('rank') }}" min="1" placeholder="Ex: 3">
                </div>

                {{-- Appreciation --}}
                <div class="form-group">
                    <label>Appreciation</label>
                    <input type="text" name="appreciation" class="form-control"
                        value="{{ old('appreciation') }}"
                        placeholder="Ex: Bon trimestre...">
                </div>

                {{-- Remarques --}}
                <div class="form-group">
                    <label>Remarques</label>
                    <textarea name="remarks" class="form-control" rows="3"
                        placeholder="Observations...">{{ old('remarks') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- Boutons --}}
    <div class="col-md-12">
        <div class="text-right">
            <a href="{{ route('admin.report_cards.index') }}" class="btn btn-secondary me-2">
                <i class="mdi mdi-close"></i> Annuler
            </a>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="mdi mdi-check"></i> Enregistrer le bulletin
            </button>
        </div>
    </div>

</div>
</form>
@endsection

@section('scripts')
<script>
// Chargement dynamique des eleves selon la classe
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
        });
});

// {{-- Calcul automatique de la moyenne en temps reel --}}
function updateCalculs() {
    let totalPoints = 0;
    let totalCoeff  = 0;

    // {{-- Parcourir tous les inputs de notes --}}
    document.querySelectorAll('.score-input').forEach(input => {
        const score = parseFloat(input.value);
        const coeff = parseFloat(input.dataset.coeff) || 1;
        const subjectId = input.id.replace('score_', '');
        const pointsCell = document.getElementById('points_' + subjectId);

        if (!isNaN(score) && score >= 0 && score <= 20) {
            const points = score * coeff;
            totalPoints += points;
            totalCoeff  += coeff;
            pointsCell.innerHTML = `<strong>${points.toFixed(2)}</strong>`;

            // {{-- Coloration selon la note --}}
            if (score >= 16) input.style.borderColor = '#00b894';
            else if (score >= 10) input.style.borderColor = '#f59e0b';
            else input.style.borderColor = '#e74c3c';
        } else {
            pointsCell.innerHTML = '<span class="text-muted">—</span>';
            input.style.borderColor = '';
        }
    });

    // {{-- Mise a jour totaux --}}
    document.getElementById('totalCoeff').innerHTML  = `<strong>${totalCoeff}</strong>`;
    document.getElementById('totalPoints').innerHTML = `<strong>${totalPoints.toFixed(2)}</strong>`;

    // {{-- Calcul et affichage de la moyenne --}}
    if (totalCoeff > 0) {
        const moyenne = totalPoints / totalCoeff;
        document.getElementById('moyennePreview').textContent = moyenne.toFixed(2) + '/20';

        // {{-- Mention selon la moyenne --}}
        let mention = '';
        let color = '';
        if (moyenne >= 16)      { mention = 'Tres Bien';   color = '#00b894'; }
        else if (moyenne >= 14) { mention = 'Bien';        color = '#6c5ce7'; }
        else if (moyenne >= 12) { mention = 'Assez Bien';  color = '#3498db'; }
        else if (moyenne >= 10) { mention = 'Passable';    color = '#f59e0b'; }
        else                    { mention = 'Insuffisant'; color = '#e74c3c'; }

        document.getElementById('moyennePreview').style.color = color;
        document.getElementById('mentionPreview').textContent  = mention;
        document.getElementById('mentionPreview').style.color  = color;
    } else {
        document.getElementById('moyennePreview').textContent = '—';
        document.getElementById('mentionPreview').textContent = '';
    }
}

// {{-- Initialisation au chargement si old values --}}
updateCalculs();
</script>
@endsection