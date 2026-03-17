@extends('layouts.admin')

@section('title', 'Modifier Note')
@section('page-title', 'Modifier Note')
@section('breadcrumb', 'Notes > Modifier')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-star text-warning me-2"></i> Modifier la note
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Les champs marques <span class="text-danger">*</span> sont obligatoires
                    </small>
                </h4>

                <form action="{{ route('admin.grades.update', $grade) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">
                        {{-- Classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe <span class="text-danger">*</span></label>
                                <select name="class_id" id="class_id" class="form-control" required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $grade->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Annee scolaire --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Annee scolaire <span class="text-danger">*</span></label>
                                <select name="school_year_id" class="form-control" required>
                                    <option value="">-- Choisir une annee --</option>
                                 @foreach($schoolYears as $year)
                                 <option value="{{ $year->id }}" {{ old('school_year_id', $grade->school_year_id) == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                 </option>
                                 @endforeach
                             </select>
                         </div>
                        </div>

                        {{-- Eleve --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eleve <span class="text-danger">*</span></label>
                                <select name="student_id" id="student_id" class="form-control" required>
                                    {{-- Pre-rempli avec l'eleve actuel --}}
                                    <option value="{{ $grade->student_id }}">
                                        {{ $grade->student->first_name ?? '' }} {{ $grade->student->last_name ?? '' }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Matiere --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Matiere <span class="text-danger">*</span></label>
                                <select name="subject_id" class="form-control" required>
                                    <option value="">-- Choisir une matiere --</option>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $grade->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note <span class="text-danger">*</span></label>
                                <input type="number" name="score" step="0.5" min="0" max="20"
                                    class="form-control"
                                    value="{{ old('score', $grade->score) }}" required>
                            </div>
                        </div>

                        {{-- Type d'evaluation --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type d'evaluation <span class="text-danger">*</span></label>
                                <select name="grade_type" class="form-control" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="Devoir" {{ old('grade_type', $grade->grade_type) == 'Devoir' ? 'selected' : '' }}>Devoir</option>
                                    <option value="Composition" {{ old('grade_type', $grade->grade_type) == 'Composition' ? 'selected' : '' }}>Composition</option>
                                    <option value="Examen" {{ old('grade_type', $grade->grade_type) == 'Examen' ? 'selected' : '' }}>Examen</option>
                                    <option value="Interrogation" {{ old('grade_type', $grade->grade_type) == 'Interrogation' ? 'selected' : '' }}>Interrogation</option>
                                </select>
                            </div>
                        </div>

                        {{-- Trimestre --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trimestre <span class="text-danger">*</span></label>
                                <select name="term" class="form-control" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="1" {{ old('term', $grade->term) == '1' ? 'selected' : '' }}>Trimestre 1</option>
                                    <option value="2" {{ old('term', $grade->term) == '2' ? 'selected' : '' }}>Trimestre 2</option>
                                    <option value="3" {{ old('term', $grade->term) == '3' ? 'selected' : '' }}>Trimestre 3</option>
                                </select>
                            </div>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date <span class="text-danger">*</span></label>
                                <input type="date" name="grade_date" class="form-control"
                                    value="{{ old('grade_date', $grade->grade_date) }}" required>
                            </div>
                        </div>

                        {{-- Commentaire --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Commentaire</label>
                                <input type="text" name="comment" class="form-control"
                                    value="{{ old('comment', $grade->comment) }}"
                                    placeholder="Observation optionnelle">
                            </div>
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('admin.grades.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> Mettre a jour
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