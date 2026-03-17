@extends('layouts.admin')

@section('title', 'Profil Parent')
@section('page-title', 'Profil Parent')
@section('breadcrumb', 'Parents > Profil')

@section('content')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div style="width:80px;height:80px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:32px;margin:0 auto 16px;">
                    {{ strtoupper(substr($parent->user->first_name ?? 'P', 0, 1)) }}
                </div>
                <h4>{{ $parent->user->first_name ?? '' }} {{ $parent->user->last_name ?? '' }}</h4>
                <p class="text-muted">{{ $parent->user->email ?? '' }}</p>
                <span class="badge badge-primary">Parent</span>
                <div class="mt-4">
                    <a href="{{ route('admin.parents.edit', $parent) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.parents.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informations</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Prenom</th>
                        <td>{{ $parent->user->first_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <td>{{ $parent->user->last_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $parent->user->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Telephone</th>
                        <td>{{ $parent->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Date d'ajout</th>
                        <td>{{ $parent->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Enfants --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Enfants associes</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Numero d'inscription</th>
                                <th>Date de naissance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parent->students as $student)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:34px;height:34px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;">
                                            {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                        </div>
                                        <span class="ms-2">{{ $student->first_name }} {{ $student->last_name }}</span>
                                    </div>
                                </td>
                                <td>{{ $student->registration_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Aucun enfant associe</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection