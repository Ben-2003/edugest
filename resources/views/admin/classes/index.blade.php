@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Gestion des Classes')
@section('page-title', 'Gestion des Classes')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Classes</span>
@endsection

{{-- Bouton d'ajout dans la topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.classes.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter une classe
    </a>
@endsection

@section('styles')
<style>
    /* Barre de recherche */
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; max-width:400px; margin-bottom:32px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }

    /* Grille de cartes */
    .classes-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:20px; }

    /* Carte classe */
    .class-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; transition:all 0.2s; animation:fadeUp 0.3s ease both; }
    .class-card:hover { border-color:rgba(108,99,255,0.3); transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.2); }
    .class-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
    .class-icon { width:48px; height:48px; border-radius:14px; background:linear-gradient(135deg,var(--accent),#5a52d5); display:flex; align-items:center; justify-content:center; font-size:20px; color:white; }
    .class-actions { display:flex; gap:6px; }
    .btn-icon { width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:12px; transition:all 0.2s; text-decoration:none; }
    .btn-view { background:rgba(0,212,170,0.1); color:var(--accent2); }
    .btn-view:hover { background:rgba(0,212,170,0.2); }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover { background:rgba(255,107,107,0.2); }
    .class-name { font-size:17px; font-weight:700; margin-bottom:4px; }
    .class-level { font-size:12px; color:var(--accent); font-weight:600; margin-bottom:16px; }
    .class-meta { display:flex; flex-direction:column; gap:8px; }
    .meta-row { display:flex; align-items:center; gap:8px; font-size:13px; color:var(--muted); }
    .meta-row i { width:16px; color:var(--accent); }

    /* Barre de capacité */
    .capacity-bar { margin-top:16px; }
    .capacity-label { display:flex; justify-content:space-between; font-size:12px; color:var(--muted); margin-bottom:6px; }
    .bar { height:6px; background:var(--surface2); border-radius:3px; overflow:hidden; }
    .bar-fill { height:100%; background:linear-gradient(90deg,var(--accent),var(--accent2)); border-radius:3px; }

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
    <input type="text" id="searchInput" placeholder="Rechercher une classe...">
</div>

{{-- Grille des classes ou état vide --}}
@if($classes->count() > 0)
<div class="classes-grid" id="classesGrid">
    @foreach($classes as $class)
    @php
        $enrolled = $class->enrollments->count();
        $capacity = $class->capacity ?? 30;
        $pct = $capacity > 0 ? min(100, round($enrolled / $capacity * 100)) : 0;
    @endphp
    <div class="class-card">
        <div class="class-card-header">
            <div class="class-icon"><i class="fas fa-door-open"></i></div>
            <div class="class-actions">
                <a href="{{ route('admin.classes.show', $class) }}" class="btn-icon btn-view" title="Voir"><i class="fas fa-eye"></i></a>
                <a href="{{ route('admin.classes.edit', $class) }}" class="btn-icon btn-edit" title="Modifier"><i class="fas fa-pen"></i></a>
                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon btn-del" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
        <div class="class-name">{{ $class->class_name }}</div>
        <div class="class-level">{{ $class->level }}</div>
        <div class="class-meta">
            <div class="meta-row">
                <i class="fas fa-calendar"></i>
                {{ $class->schoolYear ? $class->schoolYear->year_label : '—' }}
            </div>
            <div class="meta-row">
                <i class="fas fa-chalkboard-teacher"></i>
                {{ $class->teacher ? $class->teacher->first_name . ' ' . $class->teacher->last_name : 'Aucun titulaire' }}
            </div>
        </div>
        <div class="capacity-bar">
            <div class="capacity-label">
                <span>Effectif</span>
                <span>{{ $enrolled }} / {{ $capacity }}</span>
            </div>
            <div class="bar"><div class="bar-fill" style="width:{{ $pct }}%"></div></div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-icon"><i class="fas fa-school"></i></div>
    <div class="empty-title">Aucune classe créée</div>
    <div class="empty-text">Commencez par ajouter votre première classe</div>
</div>
@endif
@endsection

@section('scripts')
<script>
/* Recherche en temps réel */
document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.class-card').forEach(card => {
        card.style.display = card.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection