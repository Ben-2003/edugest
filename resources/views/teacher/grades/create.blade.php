@extends('layouts.teacher')

@section('title', 'Saisir une Note')
@section('page-title', 'Saisir une Note')
@section('breadcrumb', 'Notes > Saisir')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-star text-primary me-2"></i> Saisir une note
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Les champs marques <span class="text-danger">*</span> sont obligatoires
                    </small>
                </h4>

                <form action="{{ route('teacher.grades.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        {{-- Classe -- limitee aux classes de l'enseignant --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe <span class="text-danger">*</span></label>
                                <select name="class_id" id="class_id" class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une classe --</option>
                                    {{-- ✅ CORRECTION : $classes → $mesClasses --}}
                                    @foreach($mesClasses as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
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

                        {{-- Matiere --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Matiere <span class="text-danger">*</span></label>
                                <select name="subject_id" class="form-control {{ $errors->has('subject_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une matiere --</option>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note /20 <span class="text-danger">*</span></label>
                                <input type="number" name="score" step="0.5" min="0" max="20"
                                    class="form-control {{ $errors->has('score') ? 'is-invalid' : '' }}"
                                    value="{{ old('score') }}" placeholder="Ex: 14.5" required>
                                @error('score')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Type d'evaluation --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type d'evaluation</label>
                                <select name="grade_type" class="form-control">
                                    <option value="">-- Choisir --</option>
                                    <option value="Devoir" {{ old('grade_type') == 'Devoir' ? 'selected' : '' }}>Devoir</option>
                                    <option value="Composition" {{ old('grade_type') == 'Composition' ? 'selected' : '' }}>Composition</option>
                                    <option value="Examen" {{ old('grade_type') == 'Examen' ? 'selected' : '' }}>Examen</option>
                                    <option value="Interrogation" {{ old('grade_type') == 'Interrogation' ? 'selected' : '' }}>Interrogation</option>
                                </select>
                            </div>
                        </div>

                        {{-- Trimestre --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trimestre <span class="text-danger">*</span></label>
                                <select name="term" class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="1" {{ old('term') == '1' ? 'selected' : '' }}>Trimestre 1</option>
                                    <option value="2" {{ old('term') == '2' ? 'selected' : '' }}>Trimestre 2</option>
                                    <option value="3" {{ old('term') == '3' ? 'selected' : '' }}>Trimestre 3</option>
                                </select>
                                @error('term')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Annee scolaire --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Annee scolaire <span class="text-danger">*</span></label>
                                <select name="school_year_id" class="form-control {{ $errors->has('school_year_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir --</option>
                                    {{-- ✅ CORRECTION : $schoolYears doit etre envoye depuis le controller --}}
                                    @foreach($schoolYears as $year)
                                    <option value="{{ $year->id }}" {{ old('school_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_year_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Commentaire --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Commentaire</label>
                                <input type="text" name="comment" class="form-control"
                                    value="{{ old('comment') }}" placeholder="Observation optionnelle">
                            </div>
                        </div>

                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('teacher.grades.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> Enregistrer la note
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
{{-- Chargement dynamique des eleves selon la classe --}}
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