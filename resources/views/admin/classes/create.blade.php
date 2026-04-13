@extends('layouts.admin')

@section('title', 'Ajouter une Classe')
@section('page-title', 'Ajouter une Classe')
@section('breadcrumb', 'Classes > Ajouter')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-domain text-primary me-2"></i> Nouvelle classe
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Remplissez les informations de la classe
                    </small>
                </h4>

                <form action="{{ route('admin.classes.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        {{-- Nom de la classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de la classe <span class="text-danger">*</span></label>
                                <input type="text" name="class_name" class="form-control"
                                    value="{{ old('class_name') }}" placeholder="Ex: CP-A" required>
                                @error('class_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        {{-- Niveau --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Niveau <span class="text-danger">*</span></label>
                                <select name="level" class="form-control" required>
                                    <option value="">-- Choisir un niveau --</option>
                                    <optgroup label="Maternelle">
                                        @foreach(['Petite Section','Moyenne Section','Grande Section'] as $lvl)
                                            <option value="{{ $lvl }}" {{ old('level') == $lvl ? 'selected' : '' }}>
                                                {{ $lvl }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Primaire">
                                        @foreach(['CP','CE1','CE2','CM1','CM2'] as $lvl)
                                            <option value="{{ $lvl }}" {{ old('level') == $lvl ? 'selected' : '' }}>
                                                {{ $lvl }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('level')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Capacité --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Capacité maximale <span class="text-danger">*</span></label>
                                <input type="number" name="capacity" class="form-control"
                                    value="{{ old('capacity', 30) }}" min="1" max="100" required>
                                @error('capacity')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        {{-- Enseignant titulaire --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enseignant titulaire</label>
                                <select name="teacher_id" class="form-control">
                                    <option value="">-- Aucun titulaire --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->user->first_name ?? '' }} {{ $teacher->user->last_name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Année scolaire <span class="text-danger">*</span></label>
                            <input list="schoolYears" name="year_label" class="form-control" 
                                value="{{ old('year_label') }}" placeholder="Ex: 2025-2026" required>
                            <datalist id="schoolYears">
                                @foreach($schoolYears as $year)
                                    <option value="{{ $year->year_name }}">
                                @endforeach
                            </datalist>
                            @error('year_label')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> Créer la classe
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
