@extends('layouts.admin')

@section('title', 'Modifier Paiement')
@section('page-title', 'Modifier Paiement')
@section('breadcrumb', 'Paiements > Modifier')

@section('styles')
<style>
    {{-- Selecteur visuel de statut avec 3 boutons radio --}}
    .status-selector { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .status-option { display:none; }
    .status-label { display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px; border-radius:12px; border:2px solid #dee2e6; cursor:pointer; transition:all 0.2s; text-align:center; }
    .status-label:hover { border-color:#f59e0b; background:#f8f9fa; }
    .status-label i { font-size:20px; }
    .status-label span { font-size:13px; font-weight:600; }
    {{-- Couleur active selon le statut selectionne --}}
    .status-option:checked + .status-label.paye-label    { border-color:#00b894; background:rgba(0,184,148,0.1); color:#00b894; }
    .status-option:checked + .status-label.attente-label { border-color:#f59e0b; background:rgba(245,158,11,0.1); color:#f59e0b; }
    .status-option:checked + .status-label.annule-label  { border-color:#e74c3c; background:rgba(231,76,60,0.1); color:#e74c3c; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-cash text-warning me-2"></i> Modifier le paiement
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        {{ $payment->student->first_name ?? '' }} {{ $payment->student->last_name ?? '' }}
                        — {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                        — {{ number_format($payment->amount, 0, ',', ' ') }} FCFA
                    </small>
                </h4>

                <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">

                        {{-- Eleve --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eleve <span class="text-danger">*</span></label>
                                <select name="student_id" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir un eleve --</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $payment->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->last_name }} {{ $student->first_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Date de paiement --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date de paiement <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date"
                                    class="form-control {{ $errors->has('payment_date') ? 'is-invalid' : '' }}"
                                    value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')) }}" required>
                                @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Montant --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Montant (FCFA) <span class="text-danger">*</span></label>
                                <input type="number" name="amount"
                                    class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                    value="{{ old('amount', $payment->amount) }}" min="0" step="500" required>
                                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Selecteur visuel de statut avec valeur pre-selectionnee --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Statut <span class="text-danger">*</span></label>
                                <div class="status-selector">

                                    {{-- Option Paye -- valeur exacte BDD 'paye' --}}
                                    <div>
                                        <input type="radio" name="status" id="paye" value="payé" class="status-option"
                                            {{ old('status', $payment->status) == 'payé' ? 'checked' : '' }}>
                                        <label for="paye" class="status-label paye-label">
                                            <i class="mdi mdi-check-circle" style="color:#00b894;font-size:24px;"></i>
                                            <span>Paye</span>
                                        </label>
                                    </div>

                                    {{-- Option En attente -- valeur exacte BDD 'en attente' avec espace --}}
                                    <div>
                                        <input type="radio" name="status" id="en_attente" value="en attente" class="status-option"
                                            {{ old('status', $payment->status) == 'en attente' ? 'checked' : '' }}>
                                        <label for="en_attente" class="status-label attente-label">
                                            <i class="mdi mdi-clock" style="color:#f59e0b;font-size:24px;"></i>
                                            <span>En attente</span>
                                        </label>
                                    </div>

                                    {{-- Option Annule -- valeur exacte BDD 'annule' --}}
                                    <div>
                                        <input type="radio" name="status" id="annule" value="annulé" class="status-option"
                                            {{ old('status', $payment->status) == 'annulé' ? 'checked' : '' }}>
                                        <label for="annule" class="status-label annule-label">
                                            <i class="mdi mdi-close-circle" style="color:#e74c3c;font-size:24px;"></i>
                                            <span>Annule</span>
                                        </label>
                                    </div>

                                </div>
                                @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        {{-- Description optionnelle --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description <small class="text-muted">(optionnel)</small></label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Ex: Frais de scolarite Trimestre 1...">{{ old('description', $payment->description) }}</textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="mdi mdi-check"></i> Enregistrer les modifications
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection