@extends('layouts.admin')

@section('title', 'Ajouter un Eleve')
@section('page-title', 'Ajouter un Eleve')
@section('breadcrumb', 'Eleves > Ajouter')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informations de l'eleve</h4>
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Prenom</label>
                        <div class="col-sm-9">
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date de naissance</label>
                        <div class="col-sm-9">
                            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Genre</label>
                        <div class="col-sm-9">
                            <select name="gender" class="form-control" required>
                                <option value="">-- Choisir --</option>
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Lieu de naissance</label>
                        <div class="col-sm-9">
                            <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Adresse</label>
                        <div class="col-sm-9">
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary me-2">Annuler</a>
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