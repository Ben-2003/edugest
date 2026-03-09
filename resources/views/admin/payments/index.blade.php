@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Gestion des Paiements')
@section('page-title', 'Gestion des Paiements')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <span style="color:var(--text);">Paiements</span>
@endsection

{{-- Bouton d'ajout dans la topbar --}}
@section('topbar-actions')
    <a href="{{ route('admin.payments.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Nouveau paiement
    </a>
@endsection

@section('styles')
<style>
    /* ── Cartes statistiques financières ──
       Affichées en 4 colonnes en haut de page */
    .finance-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:32px; }
    .finance-card { background:var(--surface); border:1px solid var(--border); border-radius:14px; padding:20px; animation:fadeUp 0.3s ease both; }
    .finance-card-label { font-size:12px; color:var(--muted); font-weight:500; margin-bottom:8px; display:flex; align-items:center; gap:6px; }
    .finance-card-label i { font-size:11px; }
    .finance-card-amount { font-size:22px; font-weight:700; }

    /* ── Barre de recherche et filtre ── */
    .toolbar { display:flex; align-items:center; gap:12px; margin-bottom:32px; flex-wrap:wrap; }
    .search-box { display:flex; align-items:center; gap:10px; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; flex:1; min-width:200px; max-width:350px; }
    .search-box input { background:none; border:none; color:var(--text); font-size:14px; outline:none; width:100%; }
    .search-box input::placeholder { color:var(--muted); }
    .filter-select { background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:10px 16px; color:var(--text); font-size:14px; outline:none; cursor:pointer; }
    .filter-select option { background:var(--surface2); }

    /* ── Tableau des paiements ── */
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

    /* ── Infos élève dans le tableau ── */
    .student-info { display:flex; align-items:center; gap:10px; }
    .s-avatar { width:34px; height:34px; border-radius:9px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:white; flex-shrink:0; }
    .s-name { font-weight:600; font-size:13px; }

    /* ── Affichage du montant ── */
    .amount { font-weight:700; font-size:15px; }

    /* ── Badges de statut colorés ──
       payé = vert | en attente = orange | annulé = rouge */
    .status-paye    { display:inline-flex; align-items:center; gap:5px; background:rgba(0,212,170,0.1); color:var(--accent2); border:1px solid rgba(0,212,170,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .status-attente { display:inline-flex; align-items:center; gap:5px; background:rgba(245,158,11,0.1); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }
    .status-annule  { display:inline-flex; align-items:center; gap:5px; background:rgba(255,107,107,0.1); color:var(--accent3); border:1px solid rgba(255,107,107,0.3); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:600; }

    /* ── Boutons d'action par ligne ── */
    .actions { display:flex; gap:6px; }
    .btn-icon { width:32px; height:32px; border-radius:8px; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:13px; transition:all 0.2s; text-decoration:none; }
    .btn-view { background:rgba(0,212,170,0.1); color:var(--accent2); }
    .btn-view:hover { background:rgba(0,212,170,0.2); }
    .btn-edit { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .btn-edit:hover { background:rgba(245,158,11,0.2); }
    .btn-del  { background:rgba(255,107,107,0.1); color:var(--accent3); }
    .btn-del:hover { background:rgba(255,107,107,0.2); }

    /* ── État vide quand aucun paiement ── */
    .empty-state { padding:60px 24px; text-align:center; }
    .empty-icon { width:64px; height:64px; border-radius:16px; background:var(--surface2); display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 16px; }
    .empty-title { font-size:16px; font-weight:600; margin-bottom:8px; }
    .empty-text  { font-size:14px; color:var(--muted); }
</style>
@endsection

@section('content')

{{-- ── SECTION 1 : Statistiques financières ──
     Affiche les totaux par statut en haut de page --}}
<div class="finance-stats">

    {{-- Total des paiements effectués --}}
    <div class="finance-card">
        <div class="finance-card-label" style="color:var(--accent2);">
            <i class="fas fa-check-circle"></i> Montant encaissé
        </div>
        <div class="finance-card-amount" style="color:var(--accent2);">
            {{ number_format($totalPaye, 0, ',', ' ') }} FCFA
        </div>
    </div>

    {{-- Total en attente --}}
    <div class="finance-card">
        <div class="finance-card-label" style="color:#f59e0b;">
            <i class="fas fa-clock"></i> En attente
        </div>
        <div class="finance-card-amount" style="color:#f59e0b;">
            {{ number_format($totalAttente, 0, ',', ' ') }} FCFA
        </div>
    </div>

    {{-- Total annulé --}}
    <div class="finance-card">
        <div class="finance-card-label" style="color:var(--accent3);">
            <i class="fas fa-times-circle"></i> Annulé
        </div>
        <div class="finance-card-amount" style="color:var(--accent3);">
            {{ number_format($totalAnnule, 0, ',', ' ') }} FCFA
        </div>
    </div>

    {{-- Nombre total de transactions --}}
    <div class="finance-card">
        <div class="finance-card-label" style="color:var(--accent);">
            <i class="fas fa-file-invoice"></i> Transactions
        </div>
        <div class="finance-card-amount" style="color:var(--accent);">
            {{ $nombrePaiements }}
        </div>
    </div>

</div>

{{-- ── SECTION 2 : Barre de recherche et filtre par statut ── --}}
<div class="toolbar">
    <div class="search-box">
        <i class="fas fa-search" style="color:var(--muted);"></i>
        <input type="text" id="searchInput" placeholder="Rechercher un élève...">
    </div>

    {{-- Filtre par statut — valeurs exactes de la BDD :
         'payé', 'en attente' (avec espace), 'annulé' --}}
    <select class="filter-select" id="statusFilter">
        <option value="">Tous les statuts</option>
        <option value="payé">Payé</option>
        <option value="en attente">En attente</option>
        <option value="annulé">Annulé</option>
    </select>
</div>

{{-- ── SECTION 3 : Tableau des paiements ── --}}
<div class="table-card">
    <div class="table-header">
        <span class="table-title">Historique des paiements</span>
        <span class="count-badge">{{ $payments->total() }} paiement(s)</span>
    </div>

    @if($payments->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="paymentsTable">
            @foreach($payments as $payment)

            {{-- data-status stocke la valeur brute de la BDD
                 pour que le filtre JS puisse comparer exactement --}}
            <tr data-status="{{ $payment->status }}">
                <td>
                    <div class="student-info">
                        <div class="s-avatar">{{ strtoupper(substr($payment->student->first_name, 0, 1)) }}</div>
                        <div class="s-name">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</div>
                    </div>
                </td>
                <td style="color:var(--muted);">
                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                </td>
                <td>
                    <span class="amount">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</span>
                </td>
                <td>
                    {{-- Badge coloré selon la valeur exacte stockée en base --}}
                    @if($payment->status == 'payé')
                        <span class="status-paye"><i class="fas fa-check-circle"></i> Payé</span>
                    @elseif($payment->status == 'en attente')
                        <span class="status-attente"><i class="fas fa-clock"></i> En attente</span>
                    @else
                        <span class="status-annule"><i class="fas fa-times-circle"></i> Annulé</span>
                    @endif
                </td>
                <td style="color:var(--muted); font-size:13px;">
                    {{ $payment->description ?? '—' }}
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="btn-icon btn-view" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.payments.edit', $payment) }}" class="btn-icon btn-edit" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce paiement ?')">
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
        {{ $payments->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="empty-title">Aucun paiement enregistré</div>
        <div class="empty-text">Commencez par enregistrer le premier paiement</div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    /* ── Recherche et filtre combinés en temps réel ──
       - searchInput : filtre par nom d'élève dans le texte de la ligne
       - statusFilter : filtre par data-status (valeur exacte de la BDD)
       Les deux filtres s'appliquent simultanément */
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);

    function filterTable() {
        const q      = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value; /* valeur exacte BDD : payé, en attente, annulé */

        document.querySelectorAll('#paymentsTable tr').forEach(row => {
            const text      = row.textContent.toLowerCase();
            /* Lecture du data-status sur chaque ligne pour comparaison exacte */
            const rowStatus = row.getAttribute('data-status');

            const matchQ      = text.includes(q);
            /* Si aucun filtre sélectionné → affiche tout
               Sinon compare la valeur exacte du data-status avec le filtre */
            const matchStatus = status === '' || rowStatus === status;

            row.style.display = (matchQ && matchStatus) ? '' : 'none';
        });
    }
</script>
@endsection