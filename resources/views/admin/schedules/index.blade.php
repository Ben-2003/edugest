@extends('layouts.admin')

@section('title', "Emploi du Temps")
@section('page-title', "Emploi du Temps")

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Emploi du temps</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.schedules.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter un créneau
    </a>
@endsection

@section('styles')
<style>
    /* ── Filtre par classe ── */
    .toolbar { display:flex; align-items:center; gap:12px; margin-bottom:32px; flex-wrap:wrap; }
    .filter-select { background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; color:var(--text); font-size:14px; outline:none; cursor:pointer; }
    .filter-select option { background:var(--surface2); }

    /* ── Grille par jour ── */
    .days-grid { display:flex; flex-direction:column; gap:20px; }
    .day-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .day-header { padding:16px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
    .day-dot { width:10px; height:10px; border-radius:50%; background:var(--accent); }
    .day-name { font-size:15px; font-weight:700; }
    .day-count { font-size:12px; color:var(--muted); margin-left:auto; }

    /* ── Créneaux dans chaque jour ── */
    .slots-list { padding:16px 24px; display:flex; flex-direction:column; gap:10px; }
    .slot-item { display:flex; align-items:center; gap:16px; background:var(--surface2); border:1px solid var(--border); border-radius:12px; padding:14px 18px; transition:all 0.2s; }
    .slot-item:hover { border-color:var(--accent); }
    .slot-time { font-size:13px; font-weight:700; color:var(--accent); min-width:110px; display:flex; align-items:center; gap:6px; }
    .slot-subject { font-size:14px; font-weight:600; flex:1; }
    .slot-class { font-size:12px; color:var(--muted); background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:3px 10px; }
    .slot-teacher { font-size:12px; color:var(--muted); display:flex; align-items:center; gap:5px; }
    .slot-actions { display:flex; gap:6px; }
    .btn-icon { width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:12px; transition:all 0.2s; text-decoration:none; }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del  { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover  { background:rgba(255,107,107,0.2); }

    /* ── Jour vide ── */
    .day-empty { padding:20px 24px; color:var(--muted); font-size:13px; font-style:italic; }

    /* ── Couleurs des jours ── */
    .day-lundi    .day-dot { background:#6c63ff; }
    .day-mardi    .day-dot { background:#00d4aa; }
    .day-mercredi .day-dot { background:#f59e0b; }
    .day-jeudi    .day-dot { background:#ff6b6b; }
    .day-vendredi .day-dot { background:#3b82f6; }
    .day-samedi   .day-dot { background:#8b5cf6; }
</style>
@endsection

@section('content')

{{-- Filtre par classe --}}
<div class="toolbar">
    <select class="filter-select" id="classFilter">
        <option value="">Toutes les classes</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
        @endforeach
    </select>
</div>

{{-- Grille des créneaux groupés par jour --}}
<div class="days-grid" id="daysGrid">
    @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
    @php
        $slots = $byDay->get($jour, collect());
        $dayClass = 'day-' . strtolower($jour);
    @endphp
    <div class="day-card {{ $dayClass }}">
        <div class="day-header">
            <div class="day-dot"></div>
            <span class="day-name">{{ $jour }}</span>
            <span class="day-count">{{ $slots->count() }} créneau(x)</span>
        </div>

        @if($slots->count() > 0)
        <div class="slots-list">
            @foreach($slots->sortBy('start_time') as $slot)
            {{-- data-class-id pour le filtre JS --}}
            <div class="slot-item" data-class-id="{{ $slot->class_id }}">
                <div class="slot-time">
                    <i class="fas fa-clock"></i>
                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                    — {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                </div>
                <div class="slot-subject">{{ $slot->subject->subject_name }}</div>
                <span class="slot-class">{{ $slot->schoolClass->class_name }}</span>
                <div class="slot-teacher">
                    <i class="fas fa-user-tie"></i>
                    {{ $slot->teacher->first_name }} {{ $slot->teacher->last_name }}
                </div>
                <div class="slot-actions">
                    <a href="{{ route('admin.schedules.edit', $slot) }}" class="btn-icon btn-edit" title="Modifier">
                        <i class="fas fa-pen"></i>
                    </a>
                    <form action="{{ route('admin.schedules.destroy', $slot) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce créneau ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-del" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="day-empty"><i class="fas fa-info-circle" style="margin-right:6px;"></i>Aucun créneau ce jour</div>
        @endif
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    /* Filtre par classe — masque les créneaux qui ne correspondent pas */
    document.getElementById('classFilter').addEventListener('change', function() {
        const classId = this.value;

        document.querySelectorAll('.slot-item').forEach(slot => {
            if (classId === '' || slot.getAttribute('data-class-id') === classId) {
                slot.style.display = 'flex';
            } else {
                slot.style.display = 'none';
            }
        });
    });
</script>
@endsection