@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Modifier Paiement')
@section('page-title', 'Modifier le Paiement')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.payments.index') }}">Paiements</a> ›
    <span style="color:var(--text);">Modifier</span>
@endsection

@section('styles')
<style>
    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
    .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,#f59e0b,#d97706); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .form-title { font-size:16px; font-weight:600; }
    .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
    .form-body { padding:28px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, select, textarea { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus, textarea:focus { border-color:#f59e0b; box-shadow:0 0 0 3px rgba(245,158,11,0.1); }
    select option { background:var(--surface2); }
    textarea { resize:vertical; min-height:80px; }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }

    /* ── Sélecteur visuel de statut ──
       3 boutons radio stylisés en cartes cliquables */
    .status-selector { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .status-option { display:none; }
    .status-label { display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; border-radius:12px; border:2px solid var(--border); cursor:pointer; transition:all 0.2s; text-align:center; }
    .status-label:hover { border-color:#f59e0b; background:var(--surface2); }
    .status-label i { font-size:20px; }
    .status-label span { font-size:13px; font-weight:600; }
    /* Couleur active selon le statut sélectionné */
    .status-option:checked + .status-label.paye-label    { border-color:var(--accent2); background:rgba(0,212,170,0.1); color:var(--accent2); }
    .status-option:checked + .status-label.attente-label { border-color:#f59e0b; background:rgba(245,158,11,0.1); color:#f59e0b; }
    .status-option:checked + .status-label.annule-label  { border-color:var(--accent3); background:rgba(255,107,107,0.1); color:var(--accent3); }

    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(245,158,11,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { color:var(--text); }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-pen"></i></div>
        <div>
            <div class="form-title">Modifier le paiement de {{ $payment->student->first_name }} {{ $payment->student->last_name }}</div>
            <div class="form-subtitle">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }} — {{ number_format($payment->amount, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
            @csrf @method('PUT')

            {{-- Élève et date --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Élève <span>*</span></label>
                    <select name="student_id">
                        <option value="">-- Choisir un élève --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}"
                                {{ old('student_id', $payment->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->last_name }} {{ $student->first_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Date de paiement <span>*</span></label>
                    <input type="date" name="payment_date"
                           value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')) }}">
                    @error('payment_date') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Montant --}}
            <div class="form-group">
                <label>Montant (FCFA) <span>*</span></label>
                <input type="number" name="amount" value="{{ old('amount', $payment->amount) }}" min="0" step="500">
                @error('amount') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Sélecteur visuel de statut avec valeur pré-sélectionnée --}}
            <div class="form-group">
                <label>Statut <span>*</span></label>
                <div class="status-selector">

                    {{-- Option Payé — valeur 'payé' correspond exactement à la BDD --}}
                    <div>
                        <input type="radio" name="status" id="paye" value="payé" class="status-option"
                               {{ old('status', $payment->status) == 'payé' ? 'checked' : '' }}>
                        <label for="paye" class="status-label paye-label">
                            <i class="fas fa-check-circle" style="color:var(--accent2);"></i>
                            <span>Payé</span>
                        </label>
                    </div>

                    {{-- Option En attente — valeur 'en attente' avec espace correspond à la BDD --}}
                    <div>
                        <input type="radio" name="status" id="en_attente" value="en attente" class="status-option"
                               {{ old('status', $payment->status) == 'en attente' ? 'checked' : '' }}>
                        <label for="en_attente" class="status-label attente-label">
                            <i class="fas fa-clock" style="color:#f59e0b;"></i>
                            <span>En attente</span>
                        </label>
                    </div>

                    {{-- Option Annulé — valeur 'annulé' correspond exactement à la BDD --}}
                    <div>
                        <input type="radio" name="status" id="annule" value="annulé" class="status-option"
                               {{ old('status', $payment->status) == 'annulé' ? 'checked' : '' }}>
                        <label for="annule" class="status-label annule-label">
                            <i class="fas fa-times-circle" style="color:var(--accent3);"></i>
                            <span>Annulé</span>
                        </label>
                    </div>

                </div>
                @error('status') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Description optionnelle --}}
            <div class="form-group">
                <label>Description <small style="color:var(--muted); font-weight:400;">(optionnel)</small></label>
                <textarea name="description">{{ old('description', $payment->description) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer les modifications</button>
                <a href="{{ route('admin.payments.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection