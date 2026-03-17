@extends('layouts.admin')

@section('title', 'Gestion des Parents')
@section('page-title', 'Gestion des Parents')
@section('breadcrumb', 'Parents')

@section('topbar-actions')
    <a href="{{ route('admin.parents.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter un parent
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Liste des parents
                        <span class="badge badge-primary ms-2">{{ $parents->count() }}</span>
                    </h4>
                    <input type="text" id="searchInput" class="form-control w-25" placeholder="Rechercher...">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Parent</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>Enfants</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="parentTable">
                            @forelse($parents as $parent)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($parent->user->first_name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $parent->user->first_name ?? '' }} {{ $parent->user->last_name ?? '' }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $parent->user->email ?? 'N/A' }}</td>
                                <td>{{ $parent->phone ?? 'N/A' }}</td>
                                <td>
                                    @foreach($parent->students as $student)
                                        <span class="badge badge-info">{{ $student->first_name }}</span>
                                    @endforeach
                                    @if($parent->students->count() == 0)
                                        <span class="badge badge-warning">Aucun enfant</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.parents.show', $parent) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.parents.edit', $parent) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce parent ?')">
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
                                    Aucun parent enregistre
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
    document.querySelectorAll('#parentTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection