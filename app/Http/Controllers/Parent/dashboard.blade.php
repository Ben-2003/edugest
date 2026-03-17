@extends('layouts.parent')

@section('title', 'Espace Parent')
@section('page-title', 'Espace Parent')
@section('breadcrumb', 'Accueil')

@section('content')

@forelse($children as $child)
<div class="row" style="margin-bottom:30px;">
    <div class="col-md-12">
        <div class="full graph_head">
            <div class="graph_head_tit">
                <h5><i class="fa fa-user orange_color"></i> {{ $child->first_name }} {{ $child->last_name }} — {{ $child->registration_number }}</h5>
            </div>
        </div>
    </div>

    {{-- Notes --}}
    <div class="col-md-6">
        <div class="full graph_head">
            <div class="graph_head_tit"><h5>Dernières notes</h5></div>
        </div>
        @forelse($child->grades->take(5) as $grade)
        <div class="full user_status_sec">
            <div class="user_status_icon">
                <div style="width:40px;height:40px;border-radius:50%;background:{{ $grade->grade >= 10 ? '#00b894' : '#e74c3c' }};display:flex;align-items:center;justify-content:center;color:white;font-weight:700;">
                    {{ $grade->grade }}
                </div>
            </div>
            <div class="user_stat_name">
                <h6>{{ $grade->subject->subject_name ?? 'Matiere' }}</h6>
                <p>{{ $grade->grade_type ?? '' }} — {{ $grade->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
        @empty
        <p class="text-muted">Aucune note disponible.</p>
        @endforelse
    </div>

    {{-- Absences --}}
    <div class="col-md-6">
        <div class="full graph_head">
            <div class="graph_head_tit"><h5>Absences récentes</h5></div>
        </div>
        @forelse($child->attendances->take(5) as $absence)
        <div class="full user_status_sec">
            <div class="user_status_icon">
                <div style="width:40px;height:40px;border-radius:50%;background:#e74c3c;display:flex;align-items:center;justify-content:center;color:white;font-size:12px;">
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="user_stat_name">
                <h6>{{ \Carbon\Carbon::parse($absence->date)->format('d/m/Y') }}</h6>
                <p>{{ $absence->status }} — {{ $absence->reason ?? 'Sans motif' }}</p>
            </div>
        </div>
        @empty
        <p class="text-muted">Aucune absence enregistrée.</p>
        @endforelse
    </div>
</div>
@empty
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> Aucun enfant associé à votre compte.
        </div>
    </div>
</div>
@endforelse

@endsection