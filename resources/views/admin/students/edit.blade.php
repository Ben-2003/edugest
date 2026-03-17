@extends('layouts.admin')

@section('title', 'Modifier Eleve')
@section('page-title', 'Modifier Eleve')
@section('breadcrumb', 'Eleves > Modifier')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Modifier les informations</h4>
                <form action="{{ route('admin.students.update', $student) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Prenom</label>
                        <div class="col-sm-9">
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date de naissance</label>
                        <div class="col-sm-9">
                            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $student->date_of_birth) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Genre</label>
                        <div class="col-sm-9">
                            <select name="gender" class="form-control" required>
                                <option value="M" {{ $student->gender == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ $student->gender == 'F' ? 'selected' : '' }}>Feminin</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Lieu de naissance</label>
                        <div class="col-sm-9">
                            <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth', $student->place_of_birth) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Adresse</label>
                        <div class="col-sm-9">
                            <input type="text" name="address" class="form-control" value="{{ old('address', $student->address) }}">
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary me-2">Annuler</a>
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