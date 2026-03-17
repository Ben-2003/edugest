@extends('layouts.parent')

@section('title', 'Espace Parent')
@section('page-title', 'Espace Parent')
@section('breadcrumb', 'Accueil')

@section('content')

{{-- Onglets enfants --}}
@if($enfants->count() > 1)
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body py-2">
                @foreach($enfants as $enfant)
                <a href="?enfant_id={{ $enfant->id }}"
                   class="btn btn-sm {{ isset($enfantActif) && $enfantActif->id == $enfant->id ? 'btn-primary' : 'btn-outline-primary' }} me-2">
                    <i class="mdi mdi-account"></i> {{ $enfant->first_name }} {{ $enfant->last_name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@if(!isset($enfantActif) || !$enfantActif)
<div class="alert alert-info">
    <i class="mdi mdi-information"></i> Aucun enfant associe a votre compte.
</div>
@else

{{-- Statistiques --}}
<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Enfants <i class="mdi mdi-account-multiple mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $enfants->count() }}</h2>
                <h6 class="card-text">Enfants inscrits</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Moyenne <i class="mdi mdi-star mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ number_format($moyenneGenerale ?? 0, 2) }}/20</h2>
                <h6 class="card-text">Moyenne generale</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Absences <i class="mdi mdi-calendar-remove mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalAbsences }}</h2>
                <h6 class="card-text">Absences enregistrees</h6>
            </div>
        </div>
    </div>
</div>

{{-- Enfant actif info --}}
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-account text-primary"></i>
                    {{ $enfantActif->first_name }} {{ $enfantActif->last_name }}
                    <small class="text-muted">— {{ $enfantActif->registration_number }}</small>
                </h4>
            </div>
        </div>
    </div>
</div>

{{-- Notes + Absences --}}
<div class="row">
    {{-- Notes --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Notes par trimestre</h4>
                @forelse($notes as $trimestre => $notesTrimestre)
                <h6 class="mt-3 text-primary">Trimestre {{ $trimestre }}</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Matiere</th>
                                <th>Note</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notesTrimestre as $note)
                            <tr>
                                <td>{{ $note->subject->subject_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $note->score >= 10 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $note->score }}/20
                                    </span>
                                </td>
                                <td>{{ $note->grade_type ?? '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @empty
                <p class="text-muted">Aucune note disponible.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Absences --}}
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Absences recentes</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Motif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absences->take(10) as $absence)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($absence->attendance_date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $absence->status == 'absent' ? 'badge-danger' : 'badge-warning' }}">
                                        {{ $absence->status }}
                                    </span>
                                </td>
                                <td>{{ $absence->reason ?? 'Sans motif' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Aucune absence.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bulletins --}}
@if($bulletins->count() > 0)
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bulletins scolaires</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Annee scolaire</th>
                                <th>Trimestre</th>
                                <th>Moyenne</th>
                                <th>Rang</th>
                                <th>Appreciation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bulletins as $bulletin)
                            <tr>
                                <td>{{ $bulletin->schoolYear->year_name ?? 'N/A' }}</td>
                                <td>Trimestre {{ $bulletin->term }}</td>
                                <td><span class="badge badge-primary">{{ $bulletin->average }}/20</span></td>
                                <td>{{ $bulletin->rank ?? 'N/A' }}</td>
                                <td>{{ $bulletin->appreciation ?? '' }}</td>
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

@endif

@endsection