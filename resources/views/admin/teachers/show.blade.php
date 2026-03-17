@extends('layouts.admin')

@section('title', 'Profil Enseignant')
@section('page-title', 'Profil Enseignant')
@section('breadcrumb', 'Enseignants > Profil')

@section('content')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div style="width:80px;height:80px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:32px;margin:0 auto 16px;">
                    {{ strtoupper(substr($teacher->user->first_name ?? 'T', 0, 1)) }}
                </div>
                <h4>{{ $teacher->user->first_name ?? '' }} {{ $teacher->user->last_name ?? '' }}</h4>
                <p class="text-muted">{{ $teacher->user->email ?? '' }}</p>
                <span class="badge badge-success">Enseignant</span>
                <div class="mt-4">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary btn-sm">
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
                        <td>{{ $teacher->user->first_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <td>{{ $teacher->user->last_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $teacher->user->email ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Telephone</th>
                        <td>{{ $teacher->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Specialite</th>
                        <td>{{ $teacher->speciality ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Classe assignee</th>
                        <td>
                            @if($teacher->classes->count() > 0)
                                @foreach($teacher->classes as $class)
                                    <span class="badge badge-success">{{ $class->class_name }}</span>
                                @endforeach
                            @else
                                <span class="badge badge-warning">Non assigne</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Date d'ajout</th>
                        <td>{{ $teacher->created_at->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection