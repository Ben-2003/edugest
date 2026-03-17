@extends('layouts.admin')

@section('title', 'Gestion des Inscriptions')
@section('page-title', 'Gestion des Inscriptions')
@section('breadcrumb', 'Inscriptions')

{{-- Bouton ajouter en haut a droite --}}
@section('topbar-actions')
    <a href="{{ route('admin.enrollments.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter une inscription
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- En-tete avec compteur et recherche --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des inscriptions
                        <span class="badge badge-primary ms-2">{{ $enrollments->count() }}</span>
                    </h4>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Classe</th>
                                <th>Annee scolaire</th>
                                <th>Date inscription</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="enrollmentTable">
                            @forelse($enrollments as $enrollment)
                            <tr>
                                {{-- Infos eleve --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($enrollment->student->first_name ?? 'E', 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $enrollment->student->first_name ?? 'N/A' }} {{ $enrollment->student->last_name ?? '' }}</strong><br>
                                            <small class="text-muted">{{ $enrollment->student->registration_number ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Classe --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $enrollment->schoolClass->class_name ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Annee scolaire --}}
                                <td>{{ $enrollment->schoolYear->year_name ?? 'N/A' }}</td>

                                {{-- Date inscription --}}
                                <td>{{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y') }}</td>

                                {{-- Statut --}}
                                <td>
                                    <span class="badge badge-{{ ($enrollment->status ?? 'actif') == 'actif' ? 'success' : (($enrollment->status ?? '') == 'transfere' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($enrollment->status ?? 'actif') }}
                                    </span>
                                </td>

                                {{-- Actions : voir, modifier, supprimer --}}
                                <td>
                                    {{-- Voir le detail --}}
                                    <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    {{-- Modifier --}}
                                    <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette inscription ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            {{-- Aucune inscription --}}
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="mdi mdi-account-off mdi-48px d-block mb-2"></i>
                                    Aucune inscription enregistree
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
{{-- Recherche en temps reel dans le tableau --}}
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#enrollmentTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection