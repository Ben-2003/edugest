@extends('layouts.admin')

@section('title', 'Detail Classe')
@section('page-title', 'Detail Classe')
@section('breadcrumb', 'Classes > Detail')

@section('content')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div style="width:80px;height:80px;border-radius:50%;background:#e74c3c;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:32px;margin:0 auto 16px;">
                    {{ strtoupper(substr($class->class_name, 0, 1)) }}
                </div>
                <h4>{{ $class->class_name }}</h4>
                @if(isset($class->level))
                <p class="text-muted">{{ $class->level }}</p>
                @endif
                <span class="badge badge-info">{{ $class->enrollments->count() }} eleve(s)</span>
                <div class="mt-4">
                    <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary btn-sm">
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
                        <th width="40%">Nom</th>
                        <td>{{ $class->class_name }}</td>
                    </tr>
                    <tr>
                        <th>Niveau</th>
                        <td>{{ $class->level ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Capacite</th>
                        <td>{{ $class->capacity ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Enseignant</th>
                        <td>
                            @if($class->teacher && $class->teacher->user)
                                <span class="badge badge-success">
                                    {{ $class->teacher->user->first_name }} {{ $class->teacher->user->last_name }}
                                </span>
                            @else
                                <span class="badge badge-warning">Non assigne</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Nombre d'eleves</th>
                        <td><span class="badge badge-info">{{ $class->enrollments->count() }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Liste des eleves inscrits --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Eleves inscrits dans cette classe</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Numero d'inscription</th>
                                <th>Genre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($class->enrollments as $enrollment)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:34px;height:34px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;">
                                            {{ strtoupper(substr($enrollment->student->first_name ?? 'E', 0, 1)) }}
                                        </div>
                                        <span class="ms-2">
                                            {{ $enrollment->student->first_name ?? '' }} {{ $enrollment->student->last_name ?? '' }}
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $enrollment->student->registration_number ?? 'N/A' }}</td>
                                <td>
                                    @if(isset($enrollment->student->gender))
                                        <span class="badge badge-{{ $enrollment->student->gender == 'M' ? 'info' : 'danger' }}">
                                            {{ $enrollment->student->gender == 'M' ? 'Masculin' : 'Feminin' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Aucun eleve inscrit dans cette classe</td>
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