@extends('layouts.admin')

@section('title', 'Gestion des Élèves')
@section('page-title', 'Gestion des Élèves')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Élèves</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.students.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter un élève
    </a>
@endsection

@section('styles')
<style>
    .toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:74px; gap:16px; }
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; flex:1; max-width:400px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }
    .btn-add { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:11px 20px; font-size:14px; font-weight:600; cursor:pointer; text-decoration:none; transition:all 0.2s; white-space:nowrap; }
    .btn-add:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
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
    .student-info { display:flex; align-items:center; gap:12px; }
    .s-avatar { width:38px; height:38px; border-radius:10px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; color:white; flex-shrink:0; }
    .s-name { font-weight:600; font-size:14px; }
    .s-reg { font-size:12px; color:var(--muted); }
    .badge-m { background:rgba(108,99,255,0.15); color:var(--accent); border:1px solid rgba(108,99,255,0.2); border-radius:20px; padding:3px 10px; font-size:11px; font-weight:600; }
    .badge-f { background:rgba(255,107,107,0.15); color:var(--accent3); border:1px solid rgba(255,107,107,0.2); border-radius:20px; padding:3px 10px; font-size:11px; font-weight:600; }
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
<div class="toolbar" style="margin-bottom:32px;">
    <div class="search-box">
        <i class="fas fa-search" style="color:var(--muted);"></i>
        <input type="text" id="searchInput" placeholder="Rechercher un élève...">
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <span class="table-title">Liste des élèves</span>
        <span class="count-badge">{{ $students->total() }} élève(s)</span>
    </div>

    @if($students->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Date de naissance</th>
                <th>Genre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="studentTable">
            @foreach($students as $student)
            <tr>
                <td>
                    <div class="student-info">
                        <div class="s-avatar">{{ strtoupper(substr($student->first_name, 0, 1)) }}</div>
                        <div>
                            <div class="s-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                            <div class="s-reg">{{ $student->registration_number }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:var(--muted);">{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</td>
                <td>
                    <span class="{{ $student->gender == 'M' ? 'badge-m' : 'badge-f' }}">
                        <i class="fas {{ $student->gender == 'M' ? 'fa-mars' : 'fa-venus' }}"></i>
                        {{ $student->gender == 'M' ? 'Masculin' : 'Féminin' }}
                    </span>
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.students.show', $student) }}" class="btn-icon btn-view"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn-icon btn-edit"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Supprimer cet élève ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-del"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding:16px 24px; border-top:1px solid var(--border);">
        {{ $students->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="empty-title">Aucun élève inscrit</div>
        <div class="empty-text">Commencez par ajouter votre premier élève</div>
    </div>
    @endif
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