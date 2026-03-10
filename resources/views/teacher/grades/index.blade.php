@extends('layouts.teacher')

@section('title', 'Mes Notes')
@section('page-title', 'Mes Notes')

@section('breadcrumb')
    <a href="{{ route('teacher.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Notes</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('teacher.grades.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Saisir une note
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

    .score-badge { display:inline-flex; align-items:center; justify-content:center; width:44px; height:28px; border-radius:8px; font-size:13px; font-weight:700; }
    .score-good    { background:rgba(16,185,129,0.15); color:var(--accent); }
    .score-average { background:rgba(245,158,11,0.15); color:#f59e0b; }
    .score-bad     { background:rgba(255,107,107,0.15); color:var(--accent3); }

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
    <select class="filter-select" id="termFilter">
        <option value="">Tous les trimestres</option>
        <option value="Trimestre 1">Trimestre 1</option>
        <option value="Trimestre 2">Trimestre 2</option>
        <option value="Trimestre 3">Trimestre 3</option>
    </select>
</div>

<div class="table-card">
    <div class="table-header">
        <div class="table-icon"><i class="fas fa-star"></i></div>
        <span class="table-title">Mes notes saisies</span>
        <span class="count-badge">{{ $grades->count() }} note(s)</span>
    </div>

    @if($grades->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Matière</th>
                <th>Classe</th>
                <th>Trimestre</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="gradesTable">
            @foreach($grades as $grade)
            <tr data-class-id="{{ $grade->class_id }}" data-term="{{ $grade->term }}">
                <td>
                    <span style="font-weight:600;">
                        {{ $grade->student->first_name }} {{ $grade->student->last_name }}
                    </span>
                </td>
                <td>{{ $grade->subject->subject_name }}</td>
                <td>{{ $grade->schoolClass->class_name }}</td>
                <td>{{ $grade->term }}</td>
                <td>
                    @php $score = $grade->score; @endphp
                    <span class="score-badge {{ $score >= 14 ? 'score-good' : ($score >= 10 ? 'score-average' : 'score-bad') }}">
                        {{ $score }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('teacher.grades.destroy', $grade) }}" method="POST"
                          onsubmit="return confirm('Supprimer cette note ?')">
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
        <i class="fas fa-star"></i>
        Aucune note saisie pour le moment.
        <br><br>
        <a href="{{ route('teacher.grades.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Saisir la première note
        </a>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    const searchInput  = document.getElementById('searchInput');
    const classFilter  = document.getElementById('classFilter');
    const termFilter   = document.getElementById('termFilter');

    function filterTable() {
        const search  = searchInput.value.toLowerCase();
        const classId = classFilter.value;
        const term    = termFilter.value;

        document.querySelectorAll('#gradesTable tr').forEach(row => {
            const text    = row.textContent.toLowerCase();
            const rowClass = row.getAttribute('data-class-id');
            const rowTerm  = row.getAttribute('data-term');

            const matchSearch = search === '' || text.includes(search);
            const matchClass  = classId === '' || rowClass === classId;
            const matchTerm   = term === '' || rowTerm === term;

            row.style.display = (matchSearch && matchClass && matchTerm) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    classFilter.addEventListener('change', filterTable);
    termFilter.addEventListener('change', filterTable);
</script>
@endsection