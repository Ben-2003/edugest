@extends('layouts.admin')

@section('title', 'Detail Paiement')
@section('page-title', 'Detail Paiement')
@section('breadcrumb', 'Paiements > Detail')

@section('content')
<div class="row">

    {{-- Carte profil paiement --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">

                {{-- Avatar eleve --}}
                <div style="width:80px;height:80px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:32px;margin:0 auto 16px;">
                    {{ strtoupper(substr($payment->student->first_name ?? 'E', 0, 1)) }}
                </div>

                <h4>{{ $payment->student->first_name ?? '' }} {{ $payment->student->last_name ?? '' }}</h4>
                <p class="text-muted">{{ $payment->student->registration_number ?? '' }}</p>

                {{-- Badge statut --}}
                @if($payment->status == 'payé')
                    <span class="badge badge-success badge-lg">
                        <i class="mdi mdi-check-circle"></i> Paye
                    </span>
                @elseif($payment->status == 'en attente')
                    <span class="badge badge-warning badge-lg">
                        <i class="mdi mdi-clock"></i> En attente
                    </span>
                @else
                    <span class="badge badge-danger badge-lg">
                        <i class="mdi mdi-close-circle"></i> Annule
                    </span>
                @endif

                {{-- Montant mis en valeur --}}
                <div class="mt-3">
                    <h2 style="color:#00b894;font-weight:700;">
                        {{ number_format($payment->amount, 0, ',', ' ') }} FCFA
                    </h2>
                    <small class="text-muted">Montant du paiement</small>
                </div>

               <div class="mt-4">
                    {{-- Telecharger le PDF de la facture --}}
                    <a href="{{ route('admin.payments.pdf', $payment) }}" class="btn btn-success btn-sm me-2" target="_blank">
                        <i class="mdi mdi-file-pdf"></i> Telecharger Recu PDF
                    </a>
                    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Retour
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Details du paiement --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-success">
                    <i class="mdi mdi-cash me-2"></i> Informations du paiement
                </h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Eleve</th>
                        <td>{{ $payment->student->first_name ?? 'N/A' }} {{ $payment->student->last_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Numero d'inscription</th>
                        <td>{{ $payment->student->registration_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Date de paiement</th>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Montant</th>
                        <td>
                            <strong style="color:#00b894;font-size:16px;">
                                {{ number_format($payment->amount, 0, ',', ' ') }} FCFA
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Statut</th>
                        <td>
                            @if($payment->status == 'payé')
                                <span class="badge badge-success">
                                    <i class="mdi mdi-check-circle"></i> Paye
                                </span>
                            @elseif($payment->status == 'en attente')
                                <span class="badge badge-warning">
                                    <i class="mdi mdi-clock"></i> En attente
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="mdi mdi-close-circle"></i> Annule
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $payment->description ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Date d'enregistrement</th>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- Bouton supprimer --}}
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST"
            onsubmit="return confirm('Supprimer ce paiement ?')" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="mdi mdi-trash-can"></i> Supprimer ce paiement
            </button>
        </form>
    </div>
</div>

@endsection