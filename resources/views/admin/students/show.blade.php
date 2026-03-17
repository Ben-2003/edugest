@extends('layouts.admin')

@section('title', 'Profil Eleve')
@section('page-title', 'Profil Eleve')
@section('breadcrumb', 'Eleves > Profil')

@section('content')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div style="width:80px;height:80px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:32px;margin:0 auto 16px;">
                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                </div>
                <h4>{{ $student->first_name }} {{ $student->last_name }}</h4>
                <p class="text-muted">{{ $student->registration_number }}</p>
                <span class="badge badge-{{ $student->gender == 'M' ? 'info' : 'danger' }}">
                    {{ $student->gender == 'M' ? 'Masculin' : 'Feminin' }}
                </span>
                <div class="mt-4">
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informations personnelles</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Prenom</th>
                        <td>{{ $student->first_name }}</td>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <td>{{ $student->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Date de naissance</th>
                        <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Lieu de naissance</th>
                        <td>{{ $student->place_of_birth ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Genre</th>
                        <td>{{ $student->gender == 'M' ? 'Masculin' : 'Feminin' }}</td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td>{{ $student->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Date d'inscription</th>
                        <td>{{ $student->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Inscriptions --}}
@if($student->enrollments && $student->enrollments->count() > 0)
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Inscriptions</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Annee scolaire</th>
                                <th>Classe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->schoolYear->year_name ?? 'N/A' }}</td>
                                <td>{{ $enrollment->schoolClass->class_name ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection