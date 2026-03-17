@extends('layouts.admin')

@section('title', 'Gestion des Notes')
@section('page-title', 'Gestion des Notes')
@section('breadcrumb', 'Notes')

{{-- Bouton ajouter en haut a droite --}}
@section('topbar-actions')
    <a href="{{ route('admin.grades.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter une note
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- En-tete avec compteur et recherche --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des notes
                        <span class="badge badge-primary ms-2">{{ $grades->count() }}</span>
                    </h4>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Matiere</th>
                                <th>Classe</th>
                                <th>Note</th>
                                <th>Type</th>
                                <th>Trimestre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="gradeTable">
                            @forelse($grades as $grade)
                            <tr>
                                {{-- Eleve --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($grade->student->first_name ?? 'E', 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $grade->student->first_name ?? 'N/A' }} {{ $grade->student->last_name ?? '' }}</strong>
                                        </div>
                                    </div>
                                </td>

                                {{-- Matiere --}}
                                <td>{{ $grade->subject->subject_name ?? 'N/A' }}</td>

                                {{-- Classe --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $grade->schoolClass->class_name ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Note avec couleur selon resultat --}}
                                <td>
                                    <span class="badge badge-{{ $grade->score >= 10 ? 'success' : 'danger' }} " style="font-size:14px;">
                                        {{ $grade->score }}/20
                                    </span>
                                </td>

                                {{-- Type d'evaluation --}}
                                <td>{{ $grade->grade_type ?? 'N/A' }}</td>

                                {{-- Trimestre --}}
                                <td>Trimestre {{ $grade->term ?? 'N/A' }}</td>

                                {{-- Actions : modifier, supprimer --}}
                                <td>
                                    {{-- Modifier --}}
                                    <a href="{{ route('admin.grades.edit', $grade) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette note ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            {{-- Aucune note --}}
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="mdi mdi-star-off mdi-48px d-block mb-2"></i>
                                    Aucune note enregistree
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
    document.querySelectorAll('#gradeTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection