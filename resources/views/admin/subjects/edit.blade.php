@extends('layouts.admin')

@section('title', 'Modifier Matiere')
@section('page-title', 'Modifier Matiere')
@section('breadcrumb', 'Matieres > Modifier')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-book-open-variant text-warning me-2"></i> Modifier la matiere
                </h4>
                <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de la matiere <span class="text-danger">*</span></label>
                                <input type="text" name="subject_name" class="form-control" value="{{ old('subject_name', $subject->subject_name) }}" required>
                                @error('subject_name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Coefficient</label>
                                <input type="number" name="coefficient" class="form-control" value="{{ old('coefficient', $subject->coefficient ?? 1) }}" min="1" max="10">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description', $subject->description) }}" placeholder="Description optionnelle">
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary me-2">
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