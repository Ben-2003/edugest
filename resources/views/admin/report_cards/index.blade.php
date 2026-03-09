@extends('layouts.admin')

@section('title', 'Bulletins Scolaires')
@section('page-title', 'Bulletins Scolaires')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Bulletins</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.report_cards.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Nouveau bulletin
    </a>
@endsection

@section('styles')
<style>
    /* ── Barre de recherche et filtre ── */
    .toolbar { display:flex; align-items:center; gap:12px; margin-bottom:32px; flex-wrap:wrap; }
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; flex:1; min-width:200px; max-width:350px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }
    .filter-select { background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; color:var(--text); font-size:14px; outline:none; cursor:pointer; }
    .filter-select option { background:var(--surface2); }

    /* ── Tableau ── */
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

    /* ── Infos élève ── */
    .student-info { display:flex; align-items:center; gap:10px; }
    .s-avatar { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:white; flex-shrink:0; }
    .s-name { font-weight:600; font-size:13px; }

    /* ── Badge moyenne coloré selon la valeur ── */
    .avg-badge { display:inline-flex; align-items:center; justify-content:center; width:60px; height:28px; border-radius:8px; font-size:13px; font-weight:700; }
    .avg-excellent { background:rgba(0,212,170,0.15); color:var(--accent2); border:1px solid rgba(0,212,170,0.3); }
    .avg-bien      { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.3); }
    .avg-moyen     { background:rgba(245,158,11,0.15); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); }
    .avg-faible    { background:rgba(255,107,107,0.15); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); }

    /* ── Badge trimestre ── */
    .term-badge { display:inline-flex; align-items:center; gap:5px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:20px; padding:4px 10px; font-size:12px; }

    /* ── Boutons actions ── */
    .actions { display:flex; gap:6px; }
    .btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:13px; transition:all 0.2s; text-decoration:none; }
    .btn-view { background:rgba(0,212,170,0.1); color:var(--accent2); }
    .btn-view:hover { background:rgba(0,212,170,0.2); }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del  { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover  { background:rgba(255,107,107,0.2); }

    /* ── État vide ── */
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
        <input type="text" id="searchInput" placeholder="Rechercher un élève...">
    </div>
    <select class="filter-select" id="termFilter">
        <option value="">Tous les trimestres</option>
        <option value="Trimestre 1">Trimestre 1</option>
        <option value="Trimestre 2">Trimestre 2</option>
        <option value="Trimestre 3">Trimestre 3</option>
    </select>
</div>

<div class="table-card">
    <div class="table-header">
        <span class="table-title">Liste des bulletins</span>
        <span class="count-badge">{{ $reportCards->total() }} bulletin(s)</span>
    </div>

    @if($reportCards->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Année</th>
                <th>Trimestre</th>
                <th>Moyenne</th>
                <th>Appréciation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="reportTable">
            @foreach($reportCards as $card)
            @php
                /* Couleur de la moyenne selon la valeur */
                $avgClass = match(true) {
                    $card->average >= 16 => 'avg-excellent',
                    $card->average >= 12 => 'avg-bien',
                    $card->average >= 10 => 'avg-moyen',
                    default              => 'avg-faible'
                };
                /* Mention selon la moyenne */
                $mention = match(true) {
                    $card->average >= 16 => 'Très bien',
                    $card->average >= 14 => 'Bien',
                    $card->average >= 12 => 'Assez bien',
                    $card->average >= 10 => 'Passable',
                    default              => 'Insuffisant'
                };
            @endphp
            <tr>
                <td>
                    <div class="student-info">
                        <div class="s-avatar">{{ strtoupper(substr($card->student->first_name, 0, 1)) }}</div>
                        <div class="s-name">{{ $card->student->first_name }} {{ $card->student->last_name }}</div>
                    </div>
                </td>
                <td style="color:var(--muted);">{{ $card->schoolClass->class_name }}</td>
                <td style="color:var(--muted);">{{ $card->schoolYear->year_label }}</td>
                <td><span class="term-badge"><i class="fas fa-calendar"></i> {{ $card->term }}</span></td>
                <td><span class="avg-badge {{ $avgClass }}">{{ $card->average }}/20</span></td>
                <td style="color:var(--muted); font-size:13px;">{{ $mention }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.report_cards.show', $card) }}" class="btn-icon btn-view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.report_cards.edit', $card) }}" class="btn-icon btn-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.report_cards.destroy', $card) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce bulletin ?')">
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
        {{ $reportCards->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-file-alt"></i></div>
        <div class="empty-title">Aucun bulletin créé</div>
        <div class="empty-text">Commencez par créer le premier bulletin</div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    /* Recherche et filtre combinés en temps réel */
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('termFilter').addEventListener('change', filterTable);

    function filterTable() {
        const q    = document.getElementById('searchInput').value.toLowerCase();
        const term = document.getElementById('termFilter').value.toLowerCase();
        document.querySelectorAll('#reportTable tr').forEach(row => {
            const text      = row.textContent.toLowerCase();
            const matchQ    = text.includes(q);
            const matchTerm = term === '' || text.includes(term);
            row.style.display = (matchQ && matchTerm) ? '' : 'none';
        });
    }
</script>
@endsection