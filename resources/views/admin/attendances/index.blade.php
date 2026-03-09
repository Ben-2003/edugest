@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Gestion des Absences')
@section('page-title', 'Gestion des Absences')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Absences</span>
@endsection

{{-- Bouton d'ajout dans la topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.attendances.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Enregistrer une présence
    </a>
@endsection

@section('styles')
<style>
    /* Cartes statistiques mini */
    .mini-stats { display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:32px; }
    .mini-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:20px; display:flex; align-items:center; gap:14px; animation:fadeUp 0.3s ease both; }
    .mini-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; color:white; flex-shrink:0; }
    .mini-icon.green  { background:linear-gradient(135deg,var(--accent2),#00a884); }
    .mini-icon.red    { background:linear-gradient(135deg,var(--accent3),#e05555); }
    .mini-icon.orange { background:linear-gradient(135deg,#f59e0b,#d97706); }
    .mini-number { font-size:24px; font-weight:700; line-height:1; }
    .mini-label  { font-size:12px; color:var(--muted); margin-top:3px; }

    /* Barre de recherche et filtre */
    .toolbar { display:flex; align-items:center; gap:12px; margin-bottom:32px; flex-wrap:wrap; }
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; flex:1; min-width:200px; max-width:350px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }
    .filter-select { background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; color:var(--text); font-size:14px; outline:none; cursor:pointer; }
    .filter-select option { background:var(--surface2); }

    /* Tableau */
    .table-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .table-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
    .table-title { font-size:15px; font-weight:600; }
    .count-badge { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:12px 24px; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; text-align:left; border-bottom:1px solid var(--border); }
    tbody tr { border-bottom:1px solid var(--border); transition:background 0.15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:var(--surface2); }
    tbody td { padding:16px 24px; font-size:14px; vertical-align:middle; }

    /* Infos élève */
    .student-info { display:flex; align-items:center; gap:10px; }
    .s-avatar { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:white; flex-shrink:0; }
    .s-name { font-weight:600; font-size:13px; }

    /* Badges de statut */
    .status-present { display:inline-flex; align-items:center; gap:5px; background:rgba(0,212,170,0.1); color:var(--accent2); border:1px solid rgba(0,212,170,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .status-absent  { display:inline-flex; align-items:center; gap:5px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .status-late    { display:inline-flex; align-items:center; gap:5px; background:rgba(245,158,11,0.1); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }

    /* Boutons actions */
    .actions { display:flex; gap:6px; }
    .btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:13px; transition:all 0.2s; text-decoration:none; }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del  { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover  { background:rgba(255,107,107,0.2); }

    /* État vide */
    .empty-state { padding:60px 24px; text-align:center; }
    .empty-icon { width:64px; height:64px; border-radius:16px; background:var(--surface2); display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px; }
    .empty-title { font-size:16px; font-weight:600; margin-bottom:8px; }
    .empty-text  { font-size:14px; color:var(--muted); }
</style>
@endsection

@section('content')

{{-- Mini statistiques : présents, absents, retards --}}
<div class="mini-stats">
    <div class="mini-card">
        <div class="mini-icon green"><i class="fas fa-check"></i></div>
        <div>
            <div class="mini-number" style="color:var(--accent2);">{{ $totalPresent }}</div>
            <div class="mini-label">Présences</div>
        </div>
    </div>
    <div class="mini-card">
        <div class="mini-icon red"><i class="fas fa-times"></i></div>
        <div>
            <div class="mini-number" style="color:var(--accent3);">{{ $totalAbsent }}</div>
            <div class="mini-label">Absences</div>
        </div>
    </div>
    <div class="mini-card">
        <div class="mini-icon orange"><i class="fas fa-clock"></i></div>
        <div>
            <div class="mini-number" style="color:#f59e0b;">{{ $totalLate }}</div>
            <div class="mini-label">Retards</div>
        </div>
    </div>
</div>

{{-- Barre de recherche et filtre par statut --}}
<div class="toolbar">
    <div class="search-box">
        <i class="fas fa-search" style="color:var(--muted);"></i>
        <input type="text" id="searchInput" placeholder="Rechercher un élève...">
    </div>
    {{-- Filtre par statut --}}
    <select class="filter-select" id="statusFilter">
        <option value="">Tous les statuts</option>
        <option value="present">Présent</option>
        <option value="absent">Absent</option>
        <option value="late">Retard</option>
    </select>
</div>

<div class="table-card">
    <div class="table-header">
        <span class="table-title">Registre des présences</span>
        <span class="count-badge">{{ $attendances->total() }} enregistrement(s)</span>
    </div>

    @if($attendances->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="attendanceTable">
            @foreach($attendances as $attendance)
            <tr>
                <td>
                    <div class="student-info">
                        <div class="s-avatar">{{ strtoupper(substr($attendance->student->first_name, 0, 1)) }}</div>
                        <div class="s-name">{{ $attendance->student->first_name }} {{ $attendance->student->last_name }}</div>
                    </div>
                </td>
                <td style="color:var(--muted);">{{ $attendance->schoolClass->class_name }}</td>
                <td style="color:var(--muted);">
                    {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d/m/Y') }}
                </td>
                <td>
                    {{-- Badge coloré selon le statut --}}
                    @if($attendance->status == 'present')
                        <span class="status-present"><i class="fas fa-check-circle"></i> Présent</span>
                    @elseif($attendance->status == 'absent')
                        <span class="status-absent"><i class="fas fa-times-circle"></i> Absent</span>
                    @else
                        <span class="status-late"><i class="fas fa-clock"></i> Retard</span>
                    @endif
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.attendances.edit', $attendance) }}" class="btn-icon btn-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.attendances.destroy', $attendance) }}" method="POST"
                              onsubmit="return confirm('Supprimer cet enregistrement ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-del" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:16px 24px; border-top:1px solid var(--border);">
        {{ $attendances->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="empty-title">Aucune présence enregistrée</div>
        <div class="empty-text">Commencez par enregistrer la première présence</div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    /* Recherche et filtre combinés en temps réel */
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);

    function filterTable() {
        const q      = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value.toLowerCase();

        document.querySelectorAll('#attendanceTable tr').forEach(row => {
            const text        = row.textContent.toLowerCase();
            const matchQ      = text.includes(q);
            const matchStatus = status === '' || text.includes(status);
            row.style.display = (matchQ && matchStatus) ? '' : 'none';
        });
    }
</script>
@endsection