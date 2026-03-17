@extends('layouts.admin')

@section('title', 'Ajouter une Matiere')
@section('page-title', 'Ajouter une Matiere')
@section('breadcrumb', 'Matieres > Ajouter')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-book-open-variant text-primary me-2"></i> Nouvelle matiere
                </h4>
                <form action="{{ route('admin.subjects.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de la matiere <span class="text-danger">*</span></label>
                                <input type="text" name="subject_name" class="form-control" value="{{ old('subject_name') }}" placeholder="Ex: Mathematiques" required>
                                @error('subject_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coefficient</label>
                                <input type="number" name="coefficient" class="form-control" value="{{ old('coefficient', 1) }}" min="1" max="10">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Description optionnelle">
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary me-2">
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