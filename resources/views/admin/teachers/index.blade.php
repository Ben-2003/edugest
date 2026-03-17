@extends('layouts.admin')

@section('title', 'Gestion des Enseignants')
@section('page-title', 'Gestion des Enseignants')
@section('breadcrumb', 'Enseignants')

@section('topbar-actions')
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter un enseignant
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des enseignants
                        <span class="badge badge-primary ms-2">{{ $teachers->count() }}</span>
                    </h4>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Enseignant</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Classe assignee</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teacherTable">
                            @forelse($teachers as $teacher)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($teacher->user->first_name ?? 'T', 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $teacher->user->first_name ?? '' }} {{ $teacher->user->last_name ?? '' }}</strong><br>
                                            <small class="text-muted">{{ $teacher->employee_number ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $teacher->user->email ?? 'N/A' }}</td>
                                <td>{{ $teacher->phone ?? 'N/A' }}</td>
                                <td>
                                    @if($teacher->classes->count() > 0)
                                        @foreach($teacher->classes as $class)
                                            <span class="badge badge-success">{{ $class->class_name }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-warning">Non assigne</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet enseignant ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="mdi mdi-account-off mdi-48px d-block mb-2"></i>
                                    Aucun enseignant enregistre
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
    document.querySelectorAll('#teacherTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection