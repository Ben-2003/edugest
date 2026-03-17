@extends('layouts.teacher')

@section('title', 'Tableau de bord Enseignant')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Accueil')

@section('content')

{{-- Statistiques --}}
<div class="row">
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Mes classes <i class="mdi mdi-domain mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $mesClasses->count() }}</h2>
                <h6 class="card-text">Classes assignees</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Eleves <i class="mdi mdi-account-multiple mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalEleves }}</h2>
                <h6 class="card-text">Total eleves</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Notes <i class="mdi mdi-star mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalNotes }}</h2>
                <h6 class="card-text">Notes saisies</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Absences <i class="mdi mdi-calendar-remove mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalAbsences }}</h2>
                <h6 class="card-text">Absences enregistrees</h6>
            </div>
        </div>
    </div>
</div>

{{-- Mes classes + Emploi du temps --}}
<div class="row">
    {{-- Mes classes --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Mes classes</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Classe</th>
                                <th>Eleves</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mesClasses as $class)
                            <tr>
                                <td>{{ $class->class_name }}</td>
                                <td><span class="badge badge-success">{{ $class->enrollments->count() }}</span></td>
                                <td>
                                    <a href="{{ route('teacher.grades.index') }}" class="btn btn-sm btn-primary">
                                        <i class="mdi mdi-star"></i> Notes
                                    </a>
                                    <a href="{{ route('teacher.attendances.index') }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-calendar"></i> Absences
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Aucune classe assignee</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Emploi du temps --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Emploi du temps
                    <a href="{{ route('teacher.schedules') }}" class="btn btn-sm btn-info float-end">Voir tout</a>
                </h4>
                @forelse($monEmploiDuTemps as $jour => $seances)
                <h6 class="mt-3 text-primary">{{ $jour }}</h6>
                @foreach($seances as $seance)
                <div class="d-flex align-items-center mb-2">
                    <span class="badge badge-primary me-2">{{ substr($seance->start_time, 0, 5) }}</span>
                    <span>{{ $seance->subject->subject_name ?? 'Matiere' }}</span>
                    <span class="text-muted ms-2 small">— {{ $seance->schoolClass->class_name ?? '' }}</span>
                </div>
                @endforeach
                @empty
                <p class="text-muted">Aucun cours programme.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection