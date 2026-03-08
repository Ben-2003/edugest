@extends('layouts.admin')

@section('title', 'Gestion des Enseignants')
@section('page-title', 'Gestion des Enseignants')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Enseignants</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.teachers.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter un enseignant
    </a>
@endsection

@section('styles')
<style>
    .btn-add { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:11px 20px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; }
    .btn-add:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; max-width:400px; margin-bottom:32px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }
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
    .teacher-info { display:flex; align-items:center; gap:12px; }
    .t-avatar { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; color:white; flex-shrink:0; }
    .t-name { font-weight:600; font-size:14px; }
    .t-email { font-size:12px; color:var(--muted); margin-top:2px; }
    .spec-badge { display:inline-flex; align-items:center; gap:5px; background:rgba(0,212,170,0.1); color:var(--accent2); border:1px solid rgba(0,212,170,0.2); border-radius:20px; padding:4px 10px; font-size:12px; font-weight:500; }
    .actions { display:flex; gap:6px; }
    .btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:13px; transition:all 0.2s; text-decoration:none; }
    .btn-view { background:rgba(0,212,170,0.1); color:var(--accent2); }
    .btn-view:hover { background:rgba(0,212,170,0.2); }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover { background:rgba(255,107,107,0.2); }
    .empty-state { padding:60px 24px; text-align:center; }
    .empty-icon { width:64px; height:64px; border-radius:16px; background:var(--surface2); display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px; }
    .empty-title { font-size:16px; font-weight:600; margin-bottom:8px; }
    .empty-text { font-size:14px; color:var(--muted); }
</style>
@endsection

@section('content')
<div class="search-box">
    <i class="fas fa-search" style="color:var(--muted);"></i>
    <input type="text" id="searchInput" placeholder="Rechercher un enseignant...">
</div>

<div class="table-card">
    <div class="table-header">
        <span class="table-title">Liste des enseignants</span>
        <span class="count-badge">{{ $teachers->total() }} enseignant(s)</span>
    </div>

    @if($teachers->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Enseignant</th>
                <th>Téléphone</th>
                <th>Spécialisation</th>
                <th>Date d'embauche</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="teacherTable">
            @foreach($teachers as $teacher)
            <tr>
                <td>
                    <div class="teacher-info">
                        <div class="t-avatar">{{ strtoupper(substr($teacher->first_name, 0, 1)) }}</div>
                        <div>
                            <div class="t-name">{{ $teacher->first_name }} {{ $teacher->last_name }}</div>
                            <div class="t-email">{{ $teacher->email }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:var(--muted);">{{ $teacher->phone ?? '—' }}</td>
                <td>
                    @if($teacher->specialization)
                        <span class="spec-badge"><i class="fas fa-graduation-cap"></i> {{ $teacher->specialization }}</span>
                    @else
                        <span style="color:var(--muted);">—</span>
                    @endif
                </td>
                <td style="color:var(--muted);">{{ $teacher->hire_date ? \Carbon\Carbon::parse($teacher->hire_date)->format('d/m/Y') : '—' }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn-icon btn-view"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn-icon btn-edit"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Supprimer cet enseignant ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-del"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:16px 24px; border-top:1px solid var(--border);">{{ $teachers->links() }}</div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="empty-title">Aucun enseignant inscrit</div>
        <div class="empty-text">Commencez par ajouter votre premier enseignant</div>
    </div>
    @endif
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