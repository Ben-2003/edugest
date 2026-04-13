@extends('layouts.admin')

@section('title', 'Ajouter un Parent')
@section('page-title', 'Ajouter un Parent')
@section('breadcrumb', 'Parents > Ajouter')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informations du parent</h4>
                <form action="{{ route('admin.parents.store') }}" method="POST">
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
                        <label class="col-sm-3 col-form-label">Telephone</label>
                        <div class="col-sm-9">
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Enfants</label>
                        <div class="col-sm-9">
                            <input type="text" name="student_name" list="students" class="form-control" placeholder="Rechercher un étudiant...">

                            <select name="students" id="student" class=" select2 form-control">
                                <datalist id="students">
                                @foreach($students as $student)
                                    <option value="{{ $student->first_name }} {{ $student->last_name }} ({{ $student->registration_number }})">
                                @endforeach
                            </datalist>
                            </select>
                        </div>
                    </div>c
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.parents.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@pus
@endsection