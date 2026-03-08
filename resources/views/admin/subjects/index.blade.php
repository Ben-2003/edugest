@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Gestion des Matières')
@section('page-title', 'Gestion des Matières')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Matières</span>
@endsection

{{-- Bouton d'ajout dans la topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.subjects.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter une matière
    </a>
@endsection

@section('styles')
<style>
    /* Barre de recherche */
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; max-width:400px; margin-bottom:32px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }

    /* Grille de cartes */
    .subjects-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:20px; }

    /* Carte matière */
    .subject-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; transition:all 0.2s; animation:fadeUp 0.3s ease both; }
    .subject-card:hover { border-color:rgba(0,212,170,0.3); transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.2); }
    .subject-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
    .subject-icon { width:48px; height:48px; border-radius:14px; background:linear-gradient(135deg,var(--accent2),#00a884); display:flex; align-items:center; justify-content:center; font-size:20px; color:white; }
    .subject-actions { display:flex; gap:6px; }
    .btn-icon { width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:12px; transition:all 0.2s; text-decoration:none; }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover { background:rgba(255,107,107,0.2); }
    .subject-name { font-size:17px; font-weight:700; margin-bottom:8px; }
    .subject-desc { font-size:13px; color:var(--muted); line-height:1.5; }
    .subject-footer { margin-top:16px; padding-top:16px; border-top:1px solid var(--border); display:flex; align-items:center; gap:6px; font-size:12px; color:var(--muted); }

    /* État vide */
    .empty-state { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:60px 24px; text-align:center; }
    .empty-icon { width:64px; height:64px; border-radius:16px; background:var(--surface2); display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px; }
    .empty-title { font-size:16px; font-weight:600; margin-bottom:8px; }
    .empty-text { font-size:14px; color:var(--muted); }
</style>
@endsection

@section('content')
{{-- Barre de recherche --}}
<div class="search-box">
    <i class="fas fa-search" style="color:var(--muted);"></i>
    <input type="text" id="searchInput" placeholder="Rechercher une matière...">
</div>

{{-- Grille des matières ou état vide --}}
@if($subjects->count() > 0)
<div class="subjects-grid" id="subjectsGrid">
    @foreach($subjects as $subject)
    <div class="subject-card">
        <div class="subject-card-header">
            <div class="subject-icon"><i class="fas fa-book-open"></i></div>
            <div class="subject-actions">
                <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn-icon btn-edit" title="Modifier">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST"
                      onsubmit="return confirm('Supprimer cette matière ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon btn-del" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="subject-name">{{ $subject->subject_name }}</div>
        <div class="subject-desc">{{ $subject->description ?? 'Aucune description' }}</div>
        <div class="subject-footer">
            <i class="fas fa-calendar-plus"></i>
            Ajoutée le {{ \Carbon\Carbon::parse($subject->created_at)->format('d/m/Y') }}
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-icon"><i class="fas fa-book"></i></div>
    <div class="empty-title">Aucune matière créée</div>
    <div class="empty-text">Commencez par ajouter votre première matière</div>
</div>
@endif
@endsection

@section('scripts')
<script>
/* Recherche en temps réel */
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.subject-card').forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection