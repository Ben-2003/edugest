@extends('layouts.admin')

@section('title', 'Gestion des Paiements')
@section('page-title', 'Gestion des Paiements')
@section('breadcrumb', 'Paiements')

{{-- Bouton ajouter en haut a droite --}}
@section('topbar-actions')
    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Nouveau paiement
    </a>
@endsection

@section('content')

{{-- SECTION 1 : Statistiques financieres --}}
<div class="row mb-4">

    {{-- Montant encaisse --}}
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Encaisse <i class="mdi mdi-check-circle mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ number_format($totalPaye, 0, ',', ' ') }} F</h2>
                <h6 class="card-text">Total paye</h6>
            </div>
        </div>
    </div>

    {{-- Montant en attente --}}
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    En attente <i class="mdi mdi-clock mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ number_format($totalAttente, 0, ',', ' ') }} F</h2>
                <h6 class="card-text">Total en attente</h6>
            </div>
        </div>
    </div>

    {{-- Montant annule --}}
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Annule <i class="mdi mdi-close-circle mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ number_format($totalAnnule, 0, ',', ' ') }} F</h2>
                <h6 class="card-text">Total annule</h6>
            </div>
        </div>
    </div>

    {{-- Nombre total de transactions --}}
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Transactions <i class="mdi mdi-file-document mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ $nombrePaiements }}</h2>
                <h6 class="card-text">Total transactions</h6>
            </div>
        </div>
    </div>

</div>

{{-- SECTION 2 : Tableau des paiements --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- En-tete avec compteur, recherche et filtre statut --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Historique des paiements
                        <span class="badge badge-primary ms-2">{{ $payments->total() }}</span>
                    </h4>
                    <div class="d-flex gap-2">
                        {{-- Filtre par statut - valeurs exactes de la BDD --}}
                        <select id="statusFilter" class="form-control" style="width:180px;">
                            <option value="">Tous les statuts</option>
                            <option value="payé">Paye</option>
                            <option value="en attente">En attente</option>
                            <option value="annulé">Annule</option>
                        </select>
                        {{-- Recherche --}}
                        <input type="text" id="searchInput" class="form-control" style="width:200px;" placeholder="Rechercher...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="paymentsTable">
                            @forelse($payments as $payment)
                            {{-- data-status stocke la valeur brute de la BDD pour le filtre JS --}}
                            <tr data-status="{{ $payment->status }}">

                                {{-- Eleve --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($payment->student->first_name ?? 'E', 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $payment->student->first_name ?? 'N/A' }} {{ $payment->student->last_name ?? '' }}</strong>
                                        </div>
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>

                                {{-- Montant --}}
                                <td><strong>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</strong></td>

                                {{-- Statut avec badge colore selon valeur exacte BDD --}}
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

                                {{-- Description --}}
                                <td class="text-muted">{{ $payment->description ?? '—' }}</td>

                                {{-- Actions : voir, modifier, supprimer --}}
                                <td>
                                    {{-- Voir --}}
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    {{-- Modifier --}}
                                    <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce paiement ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            {{-- Aucun paiement --}}
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="mdi mdi-cash-remove mdi-48px d-block mb-2"></i>
                                    Aucun paiement enregistre
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $payments->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
{{-- Recherche et filtre combines en temps reel --}}
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);

function filterTable() {
    const q      = document.getElementById('searchInput').value.toLowerCase();
    {{-- Valeur exacte de la BDD : paye, en attente, annule --}}
    const status = document.getElementById('statusFilter').value;

    document.querySelectorAll('#paymentsTable tr').forEach(row => {
        const text      = row.textContent.toLowerCase();
        {{-- Lecture du data-status sur chaque ligne pour comparaison exacte --}}
        const rowStatus = row.getAttribute('data-status');

        const matchQ      = text.includes(q);
        const matchStatus = status === '' || rowStatus === status;
        row.style.display = (matchQ && matchStatus) ? '' : 'none';
    });
}
</script>
@endsection