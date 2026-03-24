@extends('layouts.admin')

@section('title', 'Detail Bulletin')
@section('page-title', 'Bulletin Scolaire')
@section('breadcrumb', 'Bulletins > Detail')

@section('styles')
<style>
    {{-- Barre de progression de la moyenne --}}
    .avg-bar { width:100%; height:10px; background:#e9ecef; border-radius:4px; overflow:hidden; margin-top:8px; }
    .avg-bar-fill { height:100%; border-radius:4px; }
</style>
@endsection

@section('content')
<div class="row">

    {{-- Carte profil bulletin --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">

                {{-- Avatar eleve --}}
                <div style="width:80px;height:80px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:32px;margin:0 auto 16px;">
                    {{ strtoupper(substr($reportCard->student->first_name ?? 'E', 0, 1)) }}
                </div>

                <h4>{{ $reportCard->student->first_name ?? '' }} {{ $reportCard->student->last_name ?? '' }}</h4>
                <p class="text-muted">{{ $reportCard->student->registration_number ?? '' }}</p>

                {{-- Classe et trimestre --}}
                <span class="badge badge-info me-1">{{ $reportCard->schoolClass->class_name ?? 'N/A' }}</span>
                <span class="badge badge-secondary">{{ $reportCard->term }}</span>

                {{-- Moyenne mise en valeur --}}
                <div class="mt-3">
                    @php
                        $avg = $reportCard->average ?? 0;
                        $color = match(true) {
                            $avg >= 16 => '#00b894',
                            $avg >= 12 => '#6c5ce7',
                            $avg >= 10 => '#f59e0b',
                            default    => '#e74c3c'
                        };
                        $mention = match(true) {
                            $avg >= 16 => 'Tres bien',
                            $avg >= 14 => 'Bien',
                            $avg >= 12 => 'Assez bien',
                            $avg >= 10 => 'Passable',
                            default    => 'Insuffisant'
                        };
                    @endphp
                    <h2 style="color:{{ $color }};font-weight:700;">
                        {{ number_format($avg, 2) }}/20
                    </h2>
                    <small style="color:{{ $color }};font-weight:600;">{{ $mention }}</small>
                    {{-- Barre de progression --}}
                    <div class="avg-bar mt-2">
                        <div class="avg-bar-fill" style="width:{{ ($avg/20)*100 }}%;background:{{ $color }};"></div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.report_cards.edit', $reportCard) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.report_cards.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Retour
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Details du bulletin --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">
                    <i class="mdi mdi-file-document me-2"></i> Informations du bulletin
                </h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Eleve</th>
                        <td>{{ $reportCard->student->first_name ?? 'N/A' }} {{ $reportCard->student->last_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Classe</th>
                        <td><span class="badge badge-info">{{ $reportCard->schoolClass->class_name ?? 'N/A' }}</span></td>
                    </tr>
                    <tr>
                        <th>Annee scolaire</th>
                        <td>{{ $reportCard->schoolYear->year_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Trimestre</th>
                        <td><span class="badge badge-secondary">{{ $reportCard->term }}</span></td>
                    </tr>
                    <tr>
                        <th>Moyenne generale</th>
                        <td>
                            <strong style="color:{{ $color }};font-size:16px;">
                                {{ number_format($avg, 2) }}/20
                            </strong>
                            — <span style="color:{{ $color }};">{{ $mention }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Rang</th>
                        <td>{{ $reportCard->rank ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Appreciation</th>
                        <td>{{ $reportCard->appreciation ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Remarques</th>
                        <td>{{ $reportCard->remarks ?? '—' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Notes du trimestre --}}
@if($grades->count() > 0)
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-success">
                    <i class="mdi mdi-star me-2"></i> Notes du trimestre {{ $reportCard->term }}
                </h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Matiere</th>
                                <th>Note</th>
                                <th>Type</th>
                                <th>Appreciation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                            <tr>
                                <td>{{ $grade->subject->subject_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $grade->score >= 10 ? 'success' : 'danger' }}" style="font-size:13px;">
                                        {{ $grade->score }}/20
                                    </span>
                                </td>
                                <td>{{ $grade->grade_type ?? 'N/A' }}</td>
                                <td>
                                    @if($grade->score >= 16) Tres bien
                                    @elseif($grade->score >= 14) Bien
                                    @elseif($grade->score >= 12) Assez bien
                                    @elseif($grade->score >= 10) Passable
                                    @else Insuffisant
                                    @endif
                                </td>
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

{{-- Bouton supprimer --}}
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.report_cards.destroy', $reportCard) }}" method="POST"
            onsubmit="return confirm('Supprimer ce bulletin ?')" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="mdi mdi-trash-can"></i> Supprimer ce bulletin
            </button>
        </form>
    </div>
</div>

@endsection