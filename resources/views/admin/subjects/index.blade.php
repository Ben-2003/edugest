@extends('layouts.admin')

@section('title', 'Gestion des Matieres')
@section('page-title', 'Gestion des Matieres')
@section('breadcrumb', 'Matieres')

@section('topbar-actions')
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter une matiere
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des matieres
                        <span class="badge badge-primary ms-2">{{ $subjects->count() }}</span>
                    </h4>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Matiere</th>
                                <th>Coefficient</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="subjectTable">
                            @forelse($subjects as $subject)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($subject->subject_name, 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $subject->subject_name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-info">{{ $subject->coefficient ?? 1 }}</span></td>
                                <td>{{ $subject->description ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette matiere ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="mdi mdi-book-off mdi-48px d-block mb-2"></i>
                                    Aucune matiere enregistree
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
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#subjectTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection