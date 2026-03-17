@extends('layouts.admin')

@section('title', 'Modifier Inscription')
@section('page-title', 'Modifier Inscription')
@section('breadcrumb', 'Inscriptions > Modifier')

@section('content')
<div class="row">
    <div class="col-md-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-account-edit text-warning me-2"></i> Modifier la fiche d'inscription
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        Les champs marques <span class="text-danger">*</span> sont obligatoires
                    </small>
                </h4>

                <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="POST">
                    @csrf @method('PUT')

                    {{-- SECTION 1 : Informations scolaires --}}
                    <div class="row mt-4">
                        <div class="col-md-12 mb-2">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="mdi mdi-school me-2"></i> Informations scolaires
                            </h5>
                        </div>

                        {{-- Eleve --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eleve <span class="text-danger">*</span></label>
                                <select name="student_id" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir un eleve --</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $enrollment->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->last_name }} {{ $student->first_name }}
                                        — {{ $student->registration_number }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $enrollment->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                        @if(isset($class->level)) — {{ $class->level }} @endif
                                        @if($class->schoolYear) ({{ $class->schoolYear->year_name }}) @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Date d'inscription --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date d'inscription <span class="text-danger">*</span></label>
                                <input type="date" name="enrollment_date"
                                    class="form-control {{ $errors->has('enrollment_date') ? 'is-invalid' : '' }}"
                                    value="{{ old('enrollment_date', $enrollment->enrollment_date) }}" required>
                                @error('enrollment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Statut --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="actif" {{ old('status', $enrollment->status) == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactif" {{ old('status', $enrollment->status) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                    <option value="transfere" {{ old('status', $enrollment->status) == 'transfere' ? 'selected' : '' }}>Transfere</option>
                                </select>
                            </div>
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
                                    value="{{ old('tutor_name', $enrollment->tutor_name) }}"
                                    placeholder="Nom complet du tuteur" required>
                                @error('tutor_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Lien de parente --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lien de parente <span class="text-danger">*</span></label>
                                <select name="tutor_relation" class="form-control {{ $errors->has('tutor_relation') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="Pere" {{ old('tutor_relation', $enrollment->tutor_relation) == 'Pere' ? 'selected' : '' }}>Pere</option>
                                    <option value="Mere" {{ old('tutor_relation', $enrollment->tutor_relation) == 'Mere' ? 'selected' : '' }}>Mere</option>
                                    <option value="Tuteur" {{ old('tutor_relation', $enrollment->tutor_relation) == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                                    <option value="Autre" {{ old('tutor_relation', $enrollment->tutor_relation) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('tutor_relation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Telephone tuteur --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telephone <span class="text-danger">*</span></label>
                                <input type="text" name="tutor_phone"
                                    class="form-control {{ $errors->has('tutor_phone') ? 'is-invalid' : '' }}"
                                    value="{{ old('tutor_phone', $enrollment->tutor_phone) }}"
                                    placeholder="Ex: 6XXXXXXXX" required>
                                @error('tutor_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Email tuteur --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email du tuteur</label>
                                <input type="email" name="tutor_email"
                                    class="form-control {{ $errors->has('tutor_email') ? 'is-invalid' : '' }}"
                                    value="{{ old('tutor_email', $enrollment->tutor_email) }}"
                                    placeholder="email@exemple.com">
                                @error('tutor_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                    <option value="{{ $group }}" {{ old('blood_group', $enrollment->blood_group) == $group ? 'selected' : '' }}>
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
                                    value="{{ old('medical_notes', $enrollment->medical_notes) }}"
                                    placeholder="Ex: Asthme, allergie aux arachides...">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 4 : Observations --}}
                    <div class="row mt-3">
                        <div class="col-md-12 mb-2">
                            <h5 class="text-info border-bottom pb-2">
                                <i class="mdi mdi-note-text me-2"></i> Observations
                            </h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Remarques / Observations</label>
                                <textarea name="observations" class="form-control" rows="3"
                                    placeholder="Informations complementaires...">{{ old('observations', $enrollment->observations) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="mdi mdi-check"></i> Mettre a jour
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection