@extends('layouts.admin')

@section('title', 'Parents')
@section('page-title', 'Parents')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Parents</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.parents.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter un parent
    </a>
@endsection

@section('styles')
<style>
    .toolbar { display:flex; align-items:center; gap:12px; margin-bottom:24px; flex-wrap:wrap; }
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; flex:1; max-width:320px; }
    .search-box input { background:none; border:none; outline:none; color:var(--text); font-size:14px; width:100%; }
    .table-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .table-header { padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
    .table-icon { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,#6c63ff,#5a52d5); display:flex; align-items:center; justify-content:center; font-size:14px; color:white; }
    .table-title { font-size:14px; font-weight:600; }
    .count-badge { margin-left:auto; font-size:12px; color:var(--muted); background:var(--surface2); border:1px solid var(--border); border-radius:20px; padding:3px 10px; }
    table { width:100%; border-collapse:collapse; }
    th { padding:12px 20px; text-align:left; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--border); }
    td { padding:14px 20px; font-size:13px; border-bottom:1px solid var(--border); }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:rgba(108,99,255,0.03); }
    .avatar { width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,#6c63ff,#5a52d5); display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; color:white; margin-right:10px; }
    .enfants-list { display:flex; flex-wrap:wrap; gap:6px; }
    .enfant-tag { font-size:11px; background:rgba(16,185,129,0.1); color:var(--accent); border:1px solid rgba(16,185,129,0.3); border-radius:20px; padding:2px 8px; }
    .btn-icon { width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; font-size:12px; transition:all 0.2s; text-decoration:none; }
    .btn-show { background:rgba(59,130,246,0.1); color:var(--accent2); }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-del  { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-show:hover { background:rgba(59,130,246,0.2); }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del:hover  { background:rgba(255,107,107,0.2); }
    .empty-state { padding:48px; text-align:center; color:var(--muted); }
</style>
@endsection

@section('content')
<div class="toolbar">
    <div class="search-box">
        <i class="fas fa-search" style="color:var(--muted);"></i>
        <input type="text" id="searchInput" placeholder="Rechercher un parent...">
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <div class="table-icon"><i class="fas fa-users"></i></div>
        <span class="table-title">Liste des parents</span>
        <span class="count-badge">{{ $parents->total() }} parent(s)</span>
    </div>

    @if($parents->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Parent</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Enfant(s)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="parentsTable">
            @foreach($parents as $parent)
            <tr>
                <td>
                    <div style="display:flex; align-items:center;">
                        <span class="avatar">{{ strtoupper(substr($parent->first_name, 0, 1)) }}</span>
                        <div>
                            <div style="font-weight:600;">{{ $parent->first_name }} {{ $parent->last_name }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $parent->user->email ?? '—' }}</td>
                <td>{{ $parent->phone ?? '—' }}</td>
                <td>
                    <div class="enfants-list">
                        @forelse($parent->students as $student)
                            <span class="enfant-tag">{{ $student->first_name }} {{ $student->last_name }}</span>
                        @empty
                            <span style="color:var(--muted); font-size:12px;">Aucun enfant</span>
                        @endforelse
                    </div>
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('admin.parents.show', $parent) }}" class="btn-icon btn-show" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.parents.edit', $parent) }}" class="btn-icon btn-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.parents.destroy', $parent) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce parent ?')">
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
    <div style="padding:16px 24px;">{{ $parents->links() }}</div>
    @else
    <div class="empty-state">
        <i class="fas fa-users" style="font-size:36px; margin-bottom:12px; display:block;"></i>
        Aucun parent enregistré.
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const search = this.value.toLowerCase();
        document.querySelectorAll('#parentsTable tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
        });
    });
</script>
@endsection