@extends('layouts.admin')

@section('title', 'Detail Inscription')
@section('page-title', 'Detail Inscription')
@section('breadcrumb', 'Inscriptions > Detail')

@section('content')
<div class="row">

    {{-- Infos principales --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div style="width:80px;height:80px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:32px;margin:0 auto 16px;">
                    {{ strtoupper(substr($enrollment->student->first_name ?? 'E', 0, 1)) }}
                </div>
                <h4>{{ $enrollment->student->first_name ?? '' }} {{ $enrollment->student->last_name ?? '' }}</h4>
                <p class="text-muted">{{ $enrollment->student->registration_number ?? '' }}</p>
                <span class="badge badge-{{ $enrollment->status == 'actif' ? 'success' : ($enrollment->status == 'transfere' ? 'warning' : 'danger') }}">
                    {{ ucfirst($enrollment->status ?? 'actif') }}
                </span>
                <div class="mt-4">
                    <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Infos scolaires --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">
                    <i class="mdi mdi-school me-2"></i> Informations scolaires
                </h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Eleve</th>
                        <td>{{ $enrollment->student->first_name ?? '' }} {{ $enrollment->student->last_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Numero d'inscription</th>
                        <td>{{ $enrollment->student->registration_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Classe</th>
                        <td><span class="badge badge-info">{{ $enrollment->schoolClass->class_name ?? 'N/A' }}</span></td>
                    </tr>
                    <tr>
                        <th>Date d'inscription</th>
                        <td>{{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Statut</th>
                        <td>
                            <span class="badge badge-{{ $enrollment->status == 'actif' ? 'success' : ($enrollment->status == 'transfere' ? 'warning' : 'danger') }}">
                                {{ ucfirst($enrollment->status ?? 'actif') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Infos tuteur --}}
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-success">
                    <i class="mdi mdi-account-supervisor me-2"></i> Parent / Tuteur
                </h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Nom</th>
                        <td>{{ $enrollment->tutor_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Lien de parente</th>
                        <td>{{ $enrollment->tutor_relation ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Telephone</th>
                        <td>{{ $enrollment->tutor_phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $enrollment->tutor_email ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Infos medicales --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-warning">
                    <i class="mdi mdi-medical-bag me-2"></i> Informations medicales
                </h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Groupe sanguin</th>
                        <td>
                            @if($enrollment->blood_group)
                                <span class="badge badge-danger">{{ $enrollment->blood_group }}</span>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Allergies / Maladies</th>
                        <td>{{ $enrollment->medical_notes ?? 'Aucune' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Observations --}}
@if($enrollment->observations)
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-info">
                    <i class="mdi mdi-note-text me-2"></i> Observations
                </h4>
                <p>{{ $enrollment->observations }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@endsection