@extends('layouts.parent')

@section('title', 'Espace Parent')
@section('page-title', 'Espace Parent')

@section('breadcrumb')
    <span style="color:var(--text);">Accueil</span>
@endsection

@section('styles')
<style>
    /* ── Onglets enfants ── */
    .enfants-tabs { display:flex; gap:10px; margin-bottom:28px; flex-wrap:wrap; }
    .enfant-tab { display:flex; align-items:center; gap:10px; padding:12px 20px; border-radius:12px; background:var(--surface); border:2px solid var(--border); text-decoration:none; color:var(--muted); font-size:13px; font-weight:600; transition:all 0.2s; }
    .enfant-tab:hover { border-color:var(--accent); color:var(--text); }
    .enfant-tab.active { border-color:var(--accent); background:rgba(59,130,246,0.1); color:var(--accent); }
    .enfant-avatar { width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg,var(--accent),#2563eb); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:white; }

    /* ── Stats rapides ── */
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:28px; }
    .stat-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:20px; display:flex; align-items:center; gap:14px; animation:fadeUp 0.3s ease both; }
    .stat-icon { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .stat-icon.blue   { background:linear-gradient(135deg,var(--accent),#2563eb); }
    .stat-icon.green  { background:linear-gradient(135deg,#10b981,#059669); }
    .stat-icon.red    { background:linear-gradient(135deg,var(--accent3),#e05555); }
    .stat-number { font-size:26px; font-weight:700; line-height:1; }
    .stat-label  { font-size:12px; color:var(--muted); margin-top:3px; }

    /* ── Sections ── */
    .section-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px; }
    .card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .card-header { padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
    .card-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:14px; color:white; }
    .card-icon.blue  { background:linear-gradient(135deg,var(--accent),#2563eb); }
    .card-icon.green { background:linear-gradient(135deg,#10b981,#059669); }
    .card-icon.orange{ background:linear-gradient(135deg,#f59e0b,#d97706); }
    .card-title { font-size:14px; font-weight:600; }
    .card-body { padding:20px 24px; }

    /* ── Notes par trimestre ── */
    .term-title { font-size:12px; font-weight:700; color:var(--accent); text-transform:uppercase; letter-spacing:1px; margin-bottom:12px; margin-top:16px; }
    .term-title:first-child { margin-top:0; }
    .note-item { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid var(--border); }
    .note-item:last-child { border-bottom:none; }
    .note-subject { font-size:13px; flex:1; }
    .note-score { font-size:14px; font-weight:700; }
    .score-good    { color:#10b981; }
    .score-average { color:#f59e0b; }
    .score-bad     { color:var(--accent3); }

    /* ── Absences ── */
    .absence-item { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid var(--border); }
    .absence-item:last-child { border-bottom:none; }
    .absence-date { font-size:13px; color:var(--muted); min-width:100px; }
    .status-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
    .status-present { background:rgba(16,185,129,0.15); color:#10b981; }
    .status-absent  { background:rgba(255,107,107,0.15); color:var(--accent3); }
    .status-late    { background:rgba(245,158,11,0.15);  color:#f59e0b; }

    /* ── Bulletins ── */
    .bulletin-item { display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid var(--border); }
    .bulletin-item:last-child { border-bottom:none; }
    .bulletin-term { font-size:13px; font-weight:600; flex:1; }
    .bulletin-avg  { font-size:16px; font-weight:700; color:var(--accent); }
    .mention-badge { font-size:11px; padding:3px 10px; border-radius:20px; background:rgba(59,130,246,0.15); color:var(--accent); }

    /* ── Empty ── */
    .empty-msg { color:var(--muted); font-size:13px; font-style:italic; padding:8px 0; }
</style>
@endsection

@section('content')

{{-- ── Onglets enfants ── --}}
@if($enfants->count() > 0)
<div class="enfants-tabs">
    @foreach($enfants as $enfant)
    <a href="{{ route('parent.dashboard', ['enfant_id' => $enfant->id]) }}"
       class="enfant-tab {{ isset($enfantActif) && $enfantActif->id === $enfant->id ? 'active' : '' }}">
        <div class="enfant-avatar">{{ strtoupper(substr($enfant->first_name, 0, 1)) }}</div>
        <div>
            <div>{{ $enfant->first_name }} {{ $enfant->last_name }}</div>
            <div style="font-size:11px; font-weight:400; margin-top:1px;">
                {{ $enfant->enrollments->first()?->schoolClass?->class_name ?? 'Non inscrit' }}
            </div>
        </div>
    </a>
    @endforeach
</div>
@endif

@if(!isset($enfantActif) || !$enfantActif)
<div style="text-align:center; padding:60px; color:var(--muted);">
    <i class="fas fa-child" style="font-size:48px; margin-bottom:16px; display:block;"></i>
    <p>Aucun enfant lié à votre compte.</p>
    <p style="font-size:12px; margin-top:8px;">Contactez l'administration.</p>
</div>
@else

{{-- ── Stats rapides ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
        <div>
            <div class="stat-number">
                {{ $enfantActif->enrollments->first()?->schoolClass?->class_name ?? '—' }}
            </div>
            <div class="stat-label">Classe</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-star"></i></div>
        <div>
            <div class="stat-number">
                {{ $moyenneGenerale ? number_format($moyenneGenerale, 1) : '—' }}/20
            </div>
            <div class="stat-label">Moyenne générale</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
        <div>
            <div class="stat-number">{{ $totalAbsences }}</div>
            <div class="stat-label">Absences</div>
        </div>
    </div>
</div>

{{-- ── Notes + Absences ── --}}
<div class="section-grid">

    {{-- Notes --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon green"><i class="fas fa-star"></i></div>
            <span class="card-title">Notes de {{ $enfantActif->first_name }}</span>
        </div>
        <div class="card-body">
            @forelse($notes as $terme => $notesTerme)
            <div class="term-title">{{ $terme }}</div>
            @foreach($notesTerme as $note)
            <div class="note-item">
                <span class="note-subject">{{ $note->subject->subject_name }}</span>
                <span class="note-score {{ $note->score >= 14 ? 'score-good' : ($note->score >= 10 ? 'score-average' : 'score-bad') }}">
                    {{ $note->score }}/20
                </span>
            </div>
            @endforeach
            @empty
            <p class="empty-msg">Aucune note disponible.</p>
            @endforelse
        </div>
    </div>

    {{-- Absences --}}
    <div class="card">
        <div class="card-header">
            <div class="card-icon orange"><i class="fas fa-calendar-times"></i></div>
            <span class="card-title">Absences de {{ $enfantActif->first_name }}</span>
        </div>
        <div class="card-body">
            @forelse($absences->take(10) as $absence)
            <div class="absence-item">
                <span class="absence-date">
                    {{ \Carbon\Carbon::parse($absence->attendance_date)->format('d/m/Y') }}
                </span>
                @if($absence->status === 'present')
                    <span class="status-badge status-present"><i class="fas fa-check-circle"></i> Présent</span>
                @elseif($absence->status === 'absent')
                    <span class="status-badge status-absent"><i class="fas fa-times-circle"></i> Absent</span>
                @else
                    <span class="status-badge status-late"><i class="fas fa-clock"></i> En retard</span>
                @endif
            </div>
            @empty
            <p class="empty-msg">Aucune absence enregistrée.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ── Bulletins ── --}}
<div class="card">
    <div class="card-header">
        <div class="card-icon blue"><i class="fas fa-file-alt"></i></div>
        <span class="card-title">Bulletins de {{ $enfantActif->first_name }}</span>
    </div>
    <div class="card-body">
        @forelse($bulletins as $bulletin)
        <div class="bulletin-item">
            <span class="bulletin-term">{{ $bulletin->term }} — {{ $bulletin->schoolYear->year_label }}</span>
            <span class="bulletin-avg">{{ $bulletin->average }}/20</span>
            @if($bulletin->remarks)
            <span class="mention-badge">{{ $bulletin->remarks }}</span>
            @endif
        </div>
        @empty
        <p class="empty-msg">Aucun bulletin disponible.</p>
        @endforelse
    </div>
</div>

@endif
@endsection