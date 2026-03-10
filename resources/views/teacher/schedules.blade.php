@extends('layouts.teacher')

@section('title', 'Mon Emploi du Temps')
@section('page-title', 'Mon Emploi du Temps')

@section('breadcrumb')
    <a href="{{ route('teacher.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Emploi du temps</span>
@endsection

@section('styles')
<style>
    .days-grid { display:flex; flex-direction:column; gap:20px; }
    .day-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .day-header { padding:16px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
    .day-dot { width:10px; height:10px; border-radius:50%; background:var(--accent); }
    .day-name { font-size:15px; font-weight:700; }
    .day-count { font-size:12px; color:var(--muted); margin-left:auto; }
    .slots-list { padding:16px 24px; display:flex; flex-direction:column; gap:10px; }
    .slot-item { display:flex; align-items:center; gap:16px; background:var(--surface2); border:1px solid var(--border); border-radius:12px; padding:14px 18px; }
    .slot-time { font-size:13px; font-weight:700; color:var(--accent); min-width:120px; }
    .slot-subject { font-size:14px; font-weight:600; flex:1; }
    .slot-class { font-size:12px; color:var(--muted); background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:3px 10px; }
    .day-empty { padding:20px 24px; color:var(--muted); font-size:13px; font-style:italic; }

    .day-lundi    .day-dot { background:#6c63ff; }
    .day-mardi    .day-dot { background:#00d4aa; }
    .day-mercredi .day-dot { background:#f59e0b; }
    .day-jeudi    .day-dot { background:#ff6b6b; }
    .day-vendredi .day-dot { background:#3b82f6; }
    .day-samedi   .day-dot { background:#8b5cf6; }
</style>
@endsection

@section('content')

@if($monEmploiDuTemps->isEmpty())
    <div style="text-align:center; padding:60px; color:var(--muted);">
        <i class="fas fa-calendar" style="font-size:48px; margin-bottom:16px; display:block;"></i>
        <p>Aucun créneau dans votre emploi du temps pour le moment.</p>
        <p style="font-size:12px; margin-top:8px;">Contactez l'administration pour plus d'informations.</p>
    </div>
@else
<div class="days-grid">
    @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
    @php
        $slots = $monEmploiDuTemps->get($jour, collect());
        $dayClass = 'day-' . strtolower($jour);
    @endphp
    @if($slots->count() > 0)
    <div class="day-card {{ $dayClass }}">
        <div class="day-header">
            <div class="day-dot"></div>
            <span class="day-name">{{ $jour }}</span>
            <span class="day-count">{{ $slots->count() }} créneau(x)</span>
        </div>
        <div class="slots-list">
            @foreach($slots as $slot)
            <div class="slot-item">
                <div class="slot-time">
                    <i class="fas fa-clock"></i>
                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                    — {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                </div>
                <div class="slot-subject">{{ $slot->subject->subject_name }}</div>
                <span class="slot-class">{{ $slot->schoolClass->class_name }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endforeach
</div>
@endif

@endsection