@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Détail Paiement')
@section('page-title', 'Détail du Paiement')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.payments.index') }}">Paiements</a> ›
    <span style="color:var(--text);">Détail</span>
@endsection

{{-- Boutons topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.payments.index') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Retour</a>
    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn-edit-top"><i class="fas fa-pen"></i> Modifier</a>
@endsection

@section('styles')
<style>
    .payment-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; padding:32px; max-width:600px; animation:fadeUp 0.3s ease both; }
    .payment-header { display:flex; align-items:center; gap:20px; margin-bottom:32px; padding-bottom:24px; border-bottom:1px solid var(--border); }
    .payment-icon { width:64px; height:64px; border-radius:18px; background:linear-gradient(135deg,var(--accent2),#00a884); display:flex; align-items:center; justify-content:center; font-size:28px; color:white; flex-shrink:0; }
    .payment-amount { font-size:32px; font-weight:700; }
    .payment-student { font-size:14px; color:var(--muted); margin-top:4px; }
    .info-row { display:flex; justify-content:space-between; align-items:center; padding:14px 0; border-bottom:1px solid var(--border); }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:13px; color:var(--muted); }
    .info-value { font-size:13px; font-weight:600; }
    .status-paye    { display:inline-flex; align-items:center; gap:5px; background:rgba(0,212,170,0.1); color:var(--accent2); border:1px solid rgba(0,212,170,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .status-attente { display:inline-flex; align-items:center; gap:5px; background:rgba(245,158,11,0.1); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .status-annule  { display:inline-flex; align-items:center; gap:5px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .card-actions { display:flex; gap:12px; margin-top:24px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-delete { display:flex; align-items:center; gap:8px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:10px; padding:10px 20px; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-delete:hover { background:rgba(255,107,107,0.2); }
</style>
@endsection

@section('content')
<div class="payment-card">

    {{-- En-tête avec montant --}}
    <div class="payment-header">
        <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div>
            <div class="payment-amount">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</div>
            <div class="payment-student">
                <i class="fas fa-user-graduate" style="margin-right:6px;"></i>
                {{ $payment->student->first_name }} {{ $payment->student->last_name }}
            </div>
        </div>
    </div>

    {{-- Détails du paiement --}}
    <div class="info-row">
        <span class="info-label">Élève</span>
        <span class="info-value">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Date de paiement</span>
        <span class="info-value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Montant</span>
        <span class="info-value" style="color:var(--accent2);">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</span>
    </div>
    <div class="info-row">
        <span class="info-label">Statut</span>
        <span class="info-value">
            @if($payment->status == 'paye')
                <span class="status-paye"><i class="fas fa-check-circle"></i> Payé</span>
            @elseif($payment->status == 'en_attente')
                <span class="status-attente"><i class="fas fa-clock"></i> En attente</span>
            @else
                <span class="status-annule"><i class="fas fa-times-circle"></i> Annulé</span>
            @endif
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Description</span>
        <span class="info-value">{{ $payment->description ?? '—' }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Enregistré le</span>
        <span class="info-value">{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y à H:i') }}</span>
    </div>

    {{-- Actions --}}
    <div class="card-actions">
        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST"
              onsubmit="return confirm('Supprimer ce paiement ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Supprimer</button>
        </form>
    </div>

</div>
@endsection