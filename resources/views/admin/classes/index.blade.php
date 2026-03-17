@extends('layouts.admin')

@section('title', 'Gestion des Classes')
@section('page-title', 'Gestion des Classes')
@section('breadcrumb', 'Classes')

@section('topbar-actions')
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter une classe
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des classes
                        <span class="badge badge-primary ms-2">{{ $classes->count() }}</span>
                    </h4>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Classe</th>
                                <th>Enseignant</th>
                                <th>Eleves</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="classTable">
                            @forelse($classes as $class)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#e74c3c;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($class->class_name, 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $class->class_name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($class->teacher && $class->teacher->user)
                                        <span class="badge badge-success">
                                            {{ $class->teacher->user->first_name }} {{ $class->teacher->user->last_name }}
                                        </span>
                                    @else
                                        <span class="badge badge-warning">Non assigne</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $class->enrollments->count() }} eleve(s)</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette classe ?')">
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
                                    <i class="mdi mdi-domain mdi-48px d-block mb-2"></i>
                                    Aucune classe enregistree
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
    document.querySelectorAll('#classTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection