@extends('layouts.admin')

@section('title', 'Détail Bulletin')
@section('page-title', 'Bulletin Scolaire')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.report_cards.index') }}">Bulletins</a> ›
    <span style="color:var(--text);">Détail</span>
@endsection

@section('topbar-actions')
    <a href="{{ route('admin.report_cards.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
    <a href="{{ route('admin.report_cards.edit', $reportCard) }}" class="btn-edit-top"><i class="fas fa-pen"></i> Modifier</a>
@endsection

@section('styles')
<style>
    .bulletin-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
    
    /* ── Carte d'identité du bulletin ── */
    .info-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; animation:fadeUp 0.3s ease both; }
    .info-card-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .info-icon { width:40px; height:40px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:16px; color:white; flex-shrink:0; }
    .info-icon.purple { background:linear-gradient(135deg,var(--accent),#5a52d5); }
    .info-icon.green  { background:linear-gradient(135deg,var(--accent2),#00a884); }
    .info-card-title { font-size:14px; font-weight:600; }
    .info-card-body { padding:20px 24px; }
    .info-row { display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid var(--border); }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:13px; color:var(--muted); }
    .info-value { font-size:13px; font-weight:600; }

    /* ── Grande carte moyenne ── */
    .avg-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:32px; text-align:center; animation:fadeUp 0.3s ease both; }
    .avg-circle { width:120px; height:120px; border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; margin:0 auto 16px; border:4px solid; }
    .avg-number { font-size:32px; font-weight:700; line-height:1; }
    .avg-label  { font-size:12px; color:var(--muted); margin-top:4px; }
    .mention-badge { display:inline-flex; align-items:center; gap:6px; border-radius:20px; padding:6px 16px; font-size:13px; font-weight:700; margin-top:12px; }

    /* ── Tableau des notes détaillées ── */
    .grades-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; margin-top:24px; animation:fadeUp 0.3s ease both; grid-column:1/-1; }
    .grades-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
    .grades-title { font-size:14px; font-weight:600; }
    table { width:100%; border-collapse:collapse; }
    thead th { padding:12px 24px; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:1px; text-align:left; border-bottom:1px solid var(--border); }
    tbody tr { border-bottom:1px solid var(--border); transition:background 0.15s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:var(--surface2); }
    tbody td { padding:14px 24px; font-size:14px; }
    .score-badge { display:inline-flex; align-items:center; justify-content:center; width:52px; height:26px; border-radius:7px; font-size:13px; font-weight:700; }
    .score-excellent { background:rgba(0,212,170,0.15); color:var(--accent2); }
    .score-bien      { background:rgba(108,99,255,0.15); color:var(--accent); }
    .score-moyen     { background:rgba(245,158,11,0.15); color:#f59e0b; }
    .score-faible    { background:rgba(255,107,107,0.15); color:var(--accent3); }

    /* ── Remarques ── */
    .remarks-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:24px; margin-top:24px; animation:fadeUp 0.3s ease both; grid-column:1/-1; }
    .remarks-title { font-size:14px; font-weight:600; margin-bottom:12px; display:flex; align-items:center; gap:8px; }
    .remarks-text { font-size:14px; color:var(--muted); line-height:1.7; font-style:italic; }
</style>
@endsection

@section('content')
@php
    /* Calcul de la couleur et mention selon la moyenne */
    $avg = $reportCard->average;
    $color = match(true) {
        $avg >= 16 => 'var(--accent2)',
        $avg >= 12 => 'var(--accent)',
        $avg >= 10 => '#f59e0b',
        default    => 'var(--accent3)'
    };
    $mention = match(true) {
        $avg >= 16 => ['label' => 'Très bien',   'bg' => 'rgba(0,212,170,0.1)',   'border' => 'rgba(0,212,170,0.3)'],
        $avg >= 14 => ['label' => 'Bien',         'bg' => 'rgba(108,99,255,0.1)',  'border' => 'rgba(108,99,255,0.3)'],
        $avg >= 12 => ['label' => 'Assez bien',   'bg' => 'rgba(108,99,255,0.1)',  'border' => 'rgba(108,99,255,0.3)'],
        $avg >= 10 => ['label' => 'Passable',     'bg' => 'rgba(245,158,11,0.1)',  'border' => 'rgba(245,158,11,0.3)'],
        default    => ['label' => 'Insuffisant',  'bg' => 'rgba(255,107,107,0.1)', 'border' => 'rgba(255,107,107,0.3)'],
    };
@endphp

<div class="bulletin-grid">

    {{-- Infos du bulletin --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-icon purple"><i class="fas fa-file-alt"></i></div>
            <span class="info-card-title">Informations du bulletin</span>
        </div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="info-label">Élève</span>
                <span class="info-value">{{ $reportCard->student->first_name }} {{ $reportCard->student->last_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Classe</span>
                <span class="info-value">{{ $reportCard->schoolClass->class_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Année scolaire</span>
                <span class="info-value">{{ $reportCard->schoolYear->year_label }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Trimestre</span>
                <span class="info-value">{{ $reportCard->term }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Créé le</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($reportCard->created_at)->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Moyenne générale avec cercle coloré --}}
    <div class="avg-card">
        <div class="avg-circle" style="border-color:{{ $color }}; background:rgba(0,0,0,0.05);">
            <span class="avg-number" style="color:{{ $color }};">{{ $reportCard->average }}</span>
            <span class="avg-label">/20</span>
        </div>
        <div style="font-size:14px; color:var(--muted);">Moyenne générale</div>
        <div class="mention-badge" style="background:{{ $mention['bg'] }}; color:{{ $color }}; border:1px solid {{ $mention['border'] }};">
            <i class="fas fa-award"></i> {{ $mention['label'] }}
        </div>
    </div>

    {{-- Notes détaillées par matière --}}
    <div class="grades-card">
        <div class="grades-header">
            <div class="info-icon green" style="width:32px;height:32px;font-size:13px;border-radius:9px;"><i class="fas fa-list"></i></div>
            <span class="grades-title">Notes par matière — {{ $reportCard->term }}</span>
        </div>
        @if($grades->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                @php
                    $scoreClass = match(true) {
                        $grade->score >= 16 => 'score-excellent',
                        $grade->score >= 12 => 'score-bien',
                        $grade->score >= 10 => 'score-moyen',
                        default             => 'score-faible'
                    };
                @endphp
                <tr>
                    <td style="font-weight:500;">{{ $grade->subject->subject_name }}</td>
                    <td><span class="score-badge {{ $scoreClass }}">{{ $grade->score }}/20</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="padding:32px 24px; text-align:center; color:var(--muted); font-size:14px;">
            <i class="fas fa-info-circle" style="margin-right:8px;"></i>
            Aucune note enregistrée pour ce trimestre
        </div>
        @endif
    </div>

    {{-- Appréciation générale --}}
    @if($reportCard->remarks)
    <div class="remarks-card">
        <div class="remarks-title">
            <i class="fas fa-comment-alt" style="color:var(--accent);"></i> Appréciation générale
        </div>
        <div class="remarks-text">"{{ $reportCard->remarks }}"</div>
    </div>
    @endif

</div>
@endsection