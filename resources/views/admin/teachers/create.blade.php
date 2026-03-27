@extends('layouts.admin')

@section('title', 'Ajouter un Enseignant')
@section('page-title', 'Ajouter un Enseignant')
@section('breadcrumb', 'Enseignants > Ajouter')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informations de l'enseignant</h4>
                <form action="{{ route('admin.teachers.store') }}" method="POST">
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
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mot de passe</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Confirmer le mot de passe</label>
                        <div class="col-sm-9">
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date d'embauche</label>
                        <div class="col-sm-9">
                            <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Telephone</label>
                        <div class="col-sm-9">
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Specialite</label>
                        <div class="col-sm-9">
                            <input type="text" name="speciality" class="form-control" value="{{ old('speciality') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Assigner une classe</label>
                        <div class="col-sm-9">
                            <select name="class_id" class="form-control">
                                <option value="">-- Aucune classe --</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary me-2">Annuler</a>
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