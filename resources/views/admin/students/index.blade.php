@extends('layouts.admin')

@section('title', 'Gestion des Eleves')
@section('page-title', 'Gestion des Eleves')
@section('breadcrumb', 'Eleves')

@section('topbar-actions')
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter un eleve
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des eleves
                        <span class="badge badge-primary ms-2">{{ $students->total() }}</span>
                    </h4>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Date de naissance</th>
                                <th>Genre</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentTable">
                            @forelse($students as $student)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $student->first_name }} {{ $student->last_name }}</strong><br>
                                            <small class="text-muted">{{ $student->registration_number }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</td>
                                <td>
                                    @if($student->gender == 'M')
                                        <span class="badge badge-info">Masculin</span>
                                    @else
                                        <span class="badge badge-danger">Feminin</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet eleve ?')">
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
                                    <i class="mdi mdi-account-off mdi-48px d-block mb-2"></i>
                                    Aucun eleve inscrit
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $students->links() }}
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
    document.querySelectorAll('#studentTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection