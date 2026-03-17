@extends('layouts.admin')

@section('title', 'Modifier Classe')
@section('page-title', 'Modifier Classe')
@section('breadcrumb', 'Classes > Modifier')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-domain text-warning me-2"></i> Modifier la classe
                    <small class="text-muted d-block mt-1" style="font-size:13px;">Modifiez les informations de la classe</small>
                </h4>
                <form action="{{ route('admin.classes.update', $class) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de la classe <span class="text-danger">*</span></label>
                                <input type="text" name="class_name" class="form-control" value="{{ old('class_name', $class->class_name) }}" required>
                                @error('class_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Niveau</label>
                                <select name="level" class="form-control">
                                    <option value="">-- Choisir un niveau --</option>
                                    <optgroup label="Maternelle">
                                        @foreach(['Petite Section','Moyenne Section','Grande Section'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $class->level ?? '') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Primaire">
                                        @foreach(['CP','CE1','CE2','CM1','CM2'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $class->level ?? '') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Capacite maximale</label>
                                <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $class->capacity ?? 30) }}" min="1" max="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enseignant titulaire</label>
                                <select name="teacher_id" class="form-control">
                                    <option value="">-- Aucun titulaire --</option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->first_name ?? '' }} {{ $teacher->user->last_name ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary me-2">
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