@extends('layouts.admin')

@section('title', 'Ajouter un Eleve')
@section('page-title', 'Ajouter un Eleve')
@section('breadcrumb', 'Eleves > Ajouter')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informations de l'élève</h4>
                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Prénom</label>
                        <div class="col-sm-9">
                            <input type="text" name="first_name" class="form-control" 
                                   value="{{ old('first_name') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <input type="text" name="last_name" class="form-control" 
                                   value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date de naissance</label>
                        <div class="col-sm-9">
                            <input type="date" name="date_of_birth" class="form-control" 
                                   value="{{ old('date_of_birth') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Genre</label>
                        <div class="col-sm-9">
                            <select name="gender" class="form-control" required>
                                <option value="">-- Choisir --</option>
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Lieu de naissance</label>
                        <div class="col-sm-9">
                            <input type="text" name="place_of_birth" class="form-control" 
                                   value="{{ old('place_of_birth') }}">
                        </div>
                    </div>

                    



                    
                    {{-- SECTION 2 : Informations du parent/tuteur --}}
                    <div class="row mt-3">
                        <div class="col-md-12 mb-2">
                            <h5 class="text-success border-bottom pb-2">
                                <i class="mdi mdi-account-supervisor me-2"></i> Informations du parent / tuteur
                            </h5>
                        </div>

                        {{-- Nom tuteur --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom du tuteur <span class="text-danger">*</span></label>
                                <input type="text" name="tutor_name"
                                    class="form-control {{ $errors->has('tutor_name') ? 'is-invalid' : '' }}"
                                    value="{{ old('tutor_name') }}"
                                    placeholder="Nom complet du tuteur" required>
                                @error('tutor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Lien de parente --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lien de parente <span class="text-danger">*</span></label>
                                <select name="tutor_relation" class="form-control {{ $errors->has('tutor_relation') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="Pere" {{ old('tutor_relation') == 'Pere' ? 'selected' : '' }}>Pere</option>
                                    <option value="Mere" {{ old('tutor_relation') == 'Mere' ? 'selected' : '' }}>Mere</option>
                                    <option value="Tuteur" {{ old('tutor_relation') == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                                    <option value="Autre" {{ old('tutor_relation') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('tutor_relation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Telephone tuteur --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telephone <span class="text-danger">*</span></label>
                                <input type="text" name="tutor_phone"
                                    class="form-control {{ $errors->has('tutor_phone') ? 'is-invalid' : '' }}"
                                    value="{{ old('tutor_phone') }}"
                                    placeholder="Ex: 6XXXXXXXX" required>
                                @error('tutor_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email tuteur --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email du tuteur</label>
                                <input type="email" name="tutor_email"
                                    class="form-control {{ $errors->has('tutor_email') ? 'is-invalid' : '' }}"
                                    value="{{ old('tutor_email') }}"
                                    placeholder="email@exemple.com">
                                @error('tutor_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3 : Informations medicales --}}
                    <div class="row mt-3">
                        <div class="col-md-12 mb-2">
                            <h5 class="text-warning border-bottom pb-2">
                                <i class="mdi mdi-medical-bag me-2"></i> Informations medicales
                                <small class="text-muted" style="font-size:12px;">(optionnel)</small>
                            </h5>
                        </div>

                        {{-- Groupe sanguin --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Groupe sanguin</label>
                                <select name="blood_group" class="form-control">
                                    <option value="">-- Choisir --</option>
                                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $group)
                                    <option value="{{ $group }}" {{ old('blood_group') == $group ? 'selected' : '' }}>
                                        {{ $group }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Allergies --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Allergies / Maladies connues</label>
                                <input type="text" name="medical_notes" class="form-control"
                                    value="{{ old('medical_notes') }}"
                                    placeholder="Ex: Asthme, allergie aux arachides...">
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Adresse</label>
                        <div class="col-sm-9">
                            <input type="text" name="address" class="form-control" 
                                   value="{{ old('address') }}">
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
