@extends('layouts.admin')

@section('title', 'Modifier Enseignant')
@section('page-title', 'Modifier Enseignant')
@section('breadcrumb', 'Enseignants > Modifier')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Modifier les informations</h4>
                <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Prenom</label>
                        <div class="col-sm-9">
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $teacher->user->first_name) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $teacher->user->last_name) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control" value="{{ old('email', $teacher->user->email) }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nouveau mot de passe</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" placeholder="Laisser vide pour ne pas changer">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Telephone</label>
                        <div class="col-sm-9">
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Specialite</label>
                        <div class="col-sm-9">
                            <input type="text" name="speciality" class="form-control" value="{{ old('speciality', $teacher->speciality) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Classe assignee</label>
                        <div class="col-sm-9">
                            <select name="class_id" class="form-control">
                                <option value="">-- Aucune classe --</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ ($teacher->classes->first()?->id == $class->id) ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary me-2">Annuler</a>
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