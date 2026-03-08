@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Gestion des Inscriptions')
@section('page-title', 'Gestion des Inscriptions')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Inscriptions</span>
@endsection

{{-- Bouton d'ajout dans la topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.enrollments.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Inscrire un élève
    </a>
@endsection

@section('styles')
<style>
    /* Barre de recherche */
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; max-width:400px; margin-bottom:32px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }

    /* Tableau */
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

    /* Infos élève */
    .student-info { display:flex; align-items:center; gap:12px; }
    .s-avatar { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; color:white; flex-shrink:0; }
    .s-name { font-weight:600; font-size:14px; }
    .s-reg { font-size:12px; color:var(--muted); }

    /* Badges */
    .class-badge { display:inline-flex; align-items:center; gap:5px; background:rgba(108,99,255,0.1); color:var(--accent); border:1px solid rgba(108,99,255,0.2); border-radius:20px; padding:4px 10px; font-size:12px; font-weight:600; }
    .year-badge { display:inline-flex; align-items:center; gap:5px; background:rgba(0,212,170,0.1); color:var(--accent2); border:1px solid rgba(0,212,170,0.2); border-radius:20px; padding:4px 10px; font-size:12px; font-weight:500; }

    /* Boutons actions */
    .actions { display:flex; gap:6px; }
    .btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:13px; transition:all 0.2s; text-decoration:none; }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover { background:rgba(255,107,107,0.2); }

    /* État vide */
    .empty-state { padding:60px 24px; text-align:center; }
    .empty-icon { width:64px; height:64px; border-radius:16px; background:var(--surface2); display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px; }
    .empty-title { font-size:16px; font-weight:600; margin-bottom:8px; }
    .empty-text { font-size:14px; color:var(--muted); }
</style>
@endsection

@section('content')
{{-- Barre de recherche --}}
<div class="search-box">
    <i class="fas fa-search" style="color:var(--muted);"></i>
    <input type="text" id="searchInput" placeholder="Rechercher un élève ou une classe...">
</div>

<div class="table-card">
    <div class="table-header">
        <span class="table-title">Liste des inscriptions</span>
        <span class="count-badge">{{ $enrollments->total() }} inscription(s)</span>
    </div>

    @if($enrollments->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Année scolaire</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="enrollTable">
            @foreach($enrollments as $enrollment)
            <tr>
                <td>
                    <div class="student-info">
                        <div class="s-avatar">{{ strtoupper(substr($enrollment->student->first_name, 0, 1)) }}</div>
                        <div>
                            <div class="s-name">{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</div>
                            <div class="s-reg">{{ $enrollment->student->registration_number }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="class-badge">
                        <i class="fas fa-door-open"></i>
                        {{ $enrollment->schoolClass->class_name }} — {{ $enrollment->schoolClass->level }}
                    </span>
                </td>
                <td>
                    <span class="year-badge">
                        <i class="fas fa-calendar"></i>
                        {{ $enrollment->schoolClass->schoolYear ? $enrollment->schoolClass->schoolYear->year_label : '—' }}
                    </span>
                </td>
                <td style="color:var(--muted);">
                    {{ \Carbon\Carbon::parse($enrollment->enrollment_date)->format('d/m/Y') }}
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="btn-icon btn-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST"
                              onsubmit="return confirm('Supprimer cette inscription ?')">
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
    <div style="padding:16px 24px; border-top:1px solid var(--border);">
        {{ $enrollments->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-user-plus"></i></div>
        <div class="empty-title">Aucune inscription</div>
        <div class="empty-text">Commencez par inscrire un élève dans une classe</div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
/* Recherche en temps réel */
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#enrollTable tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection