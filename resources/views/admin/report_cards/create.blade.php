@extends('layouts.admin')

@section('title', 'Nouveau Bulletin')
@section('page-title', 'Nouveau Bulletin')
@section('breadcrumb', 'Bulletins > Ajouter')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-file-document text-primary me-2"></i> Nouveau bulletin
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Les champs marques <span class="text-danger">*</span> sont obligatoires
                    </small>
                </h4>

                <form action="{{ route('admin.report_cards.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        {{-- Eleve --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eleve <span class="text-danger">*</span></label>
                                <select name="student_id" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir un eleve --</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->last_name }} {{ $student->first_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Annee scolaire --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Annee scolaire <span class="text-danger">*</span></label>
                                <select name="school_year_id" class="form-control {{ $errors->has('school_year_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une annee --</option>
                                    @foreach($schoolYears as $year)
                                    <option value="{{ $year->id }}" {{ old('school_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_year_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Trimestre --}}
                        <div class="col-md-6">
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

                        {{-- Moyenne generale --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Moyenne generale <span class="text-danger">*</span></label>
                                <input type="number" name="average" step="0.01" min="0" max="20"
                                    class="form-control {{ $errors->has('average') ? 'is-invalid' : '' }}"
                                    value="{{ old('average') }}" placeholder="Ex: 14.50" required>
                                @error('average')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Rang --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rang dans la classe</label>
                                <input type="number" name="rank" min="1"
                                    class="form-control"
                                    value="{{ old('rank') }}" placeholder="Ex: 3">
                            </div>
                        </div>

                        {{-- Appreciation --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Appreciation du conseil de classe</label>
                                <input type="text" name="appreciation"
                                    class="form-control"
                                    value="{{ old('appreciation') }}"
                                    placeholder="Ex: Bon trimestre, continuez vos efforts...">
                            </div>
                        </div>

                        {{-- Remarques --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Remarques</label>
                                <textarea name="remarks" class="form-control" rows="3"
                                    placeholder="Observations complementaires...">{{ old('remarks') }}</textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('admin.report_cards.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> Creer le bulletin
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection