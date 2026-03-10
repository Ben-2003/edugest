@extends('layouts.teacher')

@section('title', 'Appel / Absences')
@section('page-title', 'Appel / Absences')

@section('breadcrumb')
    <a href="{{ route('teacher.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Absences</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('teacher.attendances.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Faire l'appel
    </a>
@endsection

@section('styles')
<style>
    .toolbar { display:flex; align-items:center; gap:12px; margin-bottom:24px; flex-wrap:wrap; }
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; flex:1; max-width:320px; }
    .search-box input { background:none; border:none; outline:none; color:var(--text); font-size:14px; width:100%; }
    .filter-select { background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; color:var(--text); font-size:14px; outline:none; cursor:pointer; }
    .filter-select option { background:var(--surface2); }

    .table-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .table-header { padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
    .table-icon { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,var(--accent),#059669); display:flex; align-items:center; justify-content:center; font-size:14px; color:white; }
    .table-title { font-size:14px; font-weight:600; }
    .count-badge { margin-left:auto; font-size:12px; color:var(--muted); background:var(--surface2); border:1px solid var(--border); border-radius:20px; padding:3px 10px; }

    table { width:100%; border-collapse:collapse; }
    th { padding:12px 20px; text-align:left; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); }
    td { padding:14px 20px; font-size:13px; border-bottom:1px solid var(--border); }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:rgba(16,185,129,0.03); }

    .status-badge { display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
    .status-present { background:rgba(16,185,129,0.15); color:var(--accent); }
    .status-absent  { background:rgba(255,107,107,0.15); color:var(--accent3); }
    .status-late    { background:rgba(245,158,11,0.15);  color:#f59e0b; }

    .btn-del { width:30px; height:30px; border-radius:8px; background:rgba(255,107,107,0.1); color:var(--accent3); border:none; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; font-size:12px; transition:all 0.2s; }
    .btn-del:hover { background:rgba(255,107,107,0.2); }
    .empty-state { padding:48px; text-align:center; color:var(--muted); }
    .empty-state i { font-size:36px; margin-bottom:12px; display:block; }
</style>
@endsection

@section('content')

<div class="toolbar">
    <div class="search-box">
        <i class="fas fa-search" style="color:var(--muted);"></i>
        <input type="text" id="searchInput" placeholder="Rechercher un élève...">
    </div>
    <select class="filter-select" id="classFilter">
        <option value="">Toutes mes classes</option>
        @foreach($mesClasses as $classe)
            <option value="{{ $classe->id }}">{{ $classe->class_name }}</option>
        @endforeach
    </select>
    <select class="filter-select" id="statusFilter">
        <option value="">Tous les statuts</option>
        <option value="present">Présent</option>
        <option value="absent">Absent</option>
        <option value="late">En retard</option>
    </select>
</div>

<div class="table-card">
    <div class="table-header">
        <div class="table-icon"><i class="fas fa-calendar-check"></i></div>
        <span class="table-title">Registre des présences</span>
        <span class="count-badge">{{ $attendances->count() }} enregistrement(s)</span>
    </div>

    @if($attendances->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="attendanceTable">
            @foreach($attendances as $attendance)
            <tr data-class-id="{{ $attendance->class_id }}"
                data-status="{{ $attendance->status }}">
                <td style="font-weight:600;">
                    {{ $attendance->student->first_name }} {{ $attendance->student->last_name }}
                </td>
                <td>{{ $attendance->schoolClass->class_name }}</td>
                <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d/m/Y') }}</td>
                <td>
                    @if($attendance->status === 'present')
                        <span class="status-badge status-present"><i class="fas fa-check-circle"></i> Présent</span>
                    @elseif($attendance->status === 'absent')
                        <span class="status-badge status-absent"><i class="fas fa-times-circle"></i> Absent</span>
                    @else
                        <span class="status-badge status-late"><i class="fas fa-clock"></i> En retard</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('teacher.attendances.destroy', $attendance) }}" method="POST"
                          onsubmit="return confirm('Supprimer cet enregistrement ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class="fas fa-calendar-check"></i>
        Aucune présence enregistrée pour le moment.
        <br><br>
        <a href="{{ route('teacher.attendances.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Faire le premier appel
        </a>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    const searchInput  = document.getElementById('searchInput');
    const classFilter  = document.getElementById('classFilter');
    const statusFilter = document.getElementById('statusFilter');

    function filterTable() {
        const search   = searchInput.value.toLowerCase();
        const classId  = classFilter.value;
        const status   = statusFilter.value;

        document.querySelectorAll('#attendanceTable tr').forEach(row => {
            const text      = row.textContent.toLowerCase();
            const rowClass  = row.getAttribute('data-class-id');
            const rowStatus = row.getAttribute('data-status');

            const matchSearch = search === '' || text.includes(search);
            const matchClass  = classId === '' || rowClass === classId;
            const matchStatus = status === '' || rowStatus === status;

            row.style.display = (matchSearch && matchClass && matchStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    classFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
</script>
@endsection