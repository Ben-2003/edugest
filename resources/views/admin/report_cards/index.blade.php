@extends('layouts.admin')

@section('title', 'Gestion des Bulletins')
@section('page-title', 'Gestion des Bulletins')
@section('breadcrumb', 'Bulletins')

{{-- Bouton ajouter en haut a droite --}}
@section('topbar-actions')
    <a href="{{ route('admin.report_cards.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Generer un bulletin
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- En-tete avec compteur et recherche --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des bulletins
                        <span class="badge badge-primary ms-2">{{ $reportCards->count() }}</span>
                    </h4>
                    <div class="d-flex gap-2">
                        {{-- Filtre par trimestre --}}
                        <select id="termFilter" class="form-control" style="width:180px;">
                            <option value="">Tous les trimestres</option>
                            <option value="1">Trimestre 1</option>
                            <option value="2">Trimestre 2</option>
                            <option value="3">Trimestre 3</option>
                        </select>
                        {{-- Recherche --}}
                        <input type="text" id="searchInput" class="form-control" style="width:200px;" placeholder="Rechercher...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Classe</th>
                                <th>Annee scolaire</th>
                                <th>Trimestre</th>
                                <th>Moyenne</th>
                                <th>Rang</th>
                                <th>Appreciation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reportTable">
                            @forelse($reportCards as $report)
                            <tr>
                                {{-- Eleve --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($report->student->first_name ?? 'E', 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $report->student->first_name ?? 'N/A' }} {{ $report->student->last_name ?? '' }}</strong>
                                        </div>
                                    </div>
                                </td>

                                {{-- Classe --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $report->schoolClass->class_name ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Annee scolaire --}}
                                <td>{{ $report->schoolYear->year_name ?? 'N/A' }}</td>

                                {{-- Trimestre --}}
                                <td>Trimestre {{ $report->term }}</td>

                                {{-- Moyenne avec couleur --}}
                                <td>
                                    <span class="badge badge-{{ ($report->average ?? 0) >= 10 ? 'success' : 'danger' }}" style="font-size:14px;">
                                        {{ number_format($report->average ?? 0, 2) }}/20
                                    </span>
                                </td>

                                {{-- Rang --}}
                                <td>{{ $report->rank ?? 'N/A' }}</td>

                                {{-- Appreciation --}}
                                <td>{{ $report->appreciation ?? '—' }}</td>

                                {{-- Actions --}}
                                <td>
                                    {{-- Voir --}}
                                    <a href="{{ route('admin.report_cards.show', $report) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    {{-- Modifier --}}
                                    <a href="{{ route('admin.report_cards.edit', $report) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.report_cards.destroy', $report) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce bulletin ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            {{-- Aucun bulletin --}}
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="mdi mdi-file-document-outline mdi-48px d-block mb-2"></i>
                                    Aucun bulletin genere
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
{{-- Recherche et filtre trimestre combines en temps reel --}}
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('termFilter').addEventListener('change', filterTable);

function filterTable() {
    const q    = document.getElementById('searchInput').value.toLowerCase();
    const term = document.getElementById('termFilter').value;

    document.querySelectorAll('#reportTable tr').forEach(row => {
        const text      = row.textContent.toLowerCase();
        const matchQ    = text.includes(q);
        const matchTerm = term === '' || text.includes('trimestre ' + term);
        row.style.display = (matchQ && matchTerm) ? '' : 'none';
    });
}
</script>
@endsection