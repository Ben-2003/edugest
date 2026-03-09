@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Gestion des Notes')
@section('page-title', 'Gestion des Notes')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Notes</span>
@endsection

{{-- Bouton d'ajout dans la topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.grades.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter une note
    </a>
@endsection

@section('styles')
<style>
    /* Filtres et recherche */
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

    /* Badge note coloré selon la valeur */
    .score-badge { display:inline-flex; align-items:center; justify-content:center; width:52px; height:28px; border-radius:8px; font-size:13px; font-weight:700; }
    .score-excellent { background:rgba(0,212,170,0.15); color:var(--accent2); border:1px solid rgba(0,212,170,0.3); }
    .score-bien      { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); }
    .score-moyen     { background:rgba(245,158,11,0.15); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); }
    .score-faible    { background:rgba(255,107,107,0.15); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); }

    /* Badge trimestre */
    .term-badge { display:inline-flex; align-items:center; gap:5px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:20px; padding:4px 10px; font-size:12px; font-weight:500; }

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

{{-- Barre de recherche et filtre par trimestre --}}
<div class="toolbar">
    <div class="search-box">
        <i class="fas fa-search" style="color:var(--muted);"></i>
        <input type="text" id="searchInput" placeholder="Rechercher un élève ou matière...">
    </div>
    {{-- Filtre par trimestre --}}
    <select class="filter-select" id="termFilter">
        <option value="">Tous les trimestres</option>
        <option value="Trimestre 1">Trimestre 1</option>
        <option value="Trimestre 2">Trimestre 2</option>
        <option value="Trimestre 3">Trimestre 3</option>
    </select>
</div>

<div class="table-card">
    <div class="table-header">
        <span class="table-title">Liste des notes</span>
        <span class="count-badge">{{ $grades->total() }} note(s)</span>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="gradesTable">
            @foreach($grades as $grade)
            @php
                /* Détermination de la couleur selon la note */
                $scoreClass = match(true) {
                    $grade->score >= 16 => 'score-excellent',
                    $grade->score >= 12 => 'score-bien',
                    $grade->score >= 10 => 'score-moyen',
                    default             => 'score-faible'
                };
            @endphp
            <tr>
                <td>
                    <div class="student-info">
                        <div class="s-avatar">{{ strtoupper(substr($grade->student->first_name, 0, 1)) }}</div>
                        <div class="s-name">{{ $grade->student->first_name }} {{ $grade->student->last_name }}</div>
                    </div>
                </td>
                <td style="font-weight:500;">{{ $grade->subject->subject_name }}</td>
                <td style="color:var(--muted);">{{ $grade->schoolClass->class_name }}</td>
                <td><span class="term-badge"><i class="fas fa-calendar"></i> {{ $grade->term }}</span></td>
                <td><span class="score-badge {{ $scoreClass }}">{{ $grade->score }}/20</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.grades.edit', $grade) }}" class="btn-icon btn-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST"
                              onsubmit="return confirm('Supprimer cette note ?')">
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
        {{ $grades->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-star"></i></div>
        <div class="empty-title">Aucune note enregistrée</div>
        <div class="empty-text">Commencez par ajouter la première note</div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    /* Recherche en temps réel sur le nom de l'élève et la matière */
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('termFilter').addEventListener('change', filterTable);

    function filterTable() {
        const q    = document.getElementById('searchInput').value.toLowerCase();
        const term = document.getElementById('termFilter').value.toLowerCase();

        document.querySelectorAll('#gradesTable tr').forEach(row => {
            const text     = row.textContent.toLowerCase();
            const matchQ    = text.includes(q);
            const matchTerm = term === '' || text.includes(term);
            row.style.display = (matchQ && matchTerm) ? '' : 'none';
        });
    }
</script>
@endsection