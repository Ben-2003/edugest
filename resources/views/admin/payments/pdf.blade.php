<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture Paiement</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#333; }

        /* En-tete */
        .header { display:table; width:100%; border-bottom:3px solid #00b894; padding-bottom:15px; margin-bottom:25px; }
        .header-left { display:table-cell; width:60%; vertical-align:middle; }
        .header-right { display:table-cell; width:40%; text-align:right; vertical-align:middle; }
        .school-name { font-size:20px; font-weight:700; color:#00b894; text-transform:uppercase; }
        .school-sub { font-size:11px; color:#666; margin-top:3px; }
        .facture-title { font-size:22px; font-weight:700; color:#333; }
        .facture-num { font-size:11px; color:#666; margin-top:4px; }

        /* Badges statut */
        .status-badge { display:inline-block; padding:4px 12px; border-radius:4px; font-weight:700; font-size:12px; }
        .status-paye    { background:#d4edda; color:#155724; }
        .status-attente { background:#fff3cd; color:#856404; }
        .status-annule  { background:#f8d7da; color:#721c24; }

        /* Infos */
        .info-grid { display:table; width:100%; margin-bottom:25px; }
        .info-col { display:table-cell; width:50%; vertical-align:top; padding-right:15px; }
        .info-box { border:1px solid #dee2e6; border-radius:6px; padding:12px; }
        .info-box-title { font-size:11px; font-weight:700; color:#00b894; text-transform:uppercase; border-bottom:1px solid #dee2e6; padding-bottom:6px; margin-bottom:8px; }
        .info-line { margin-bottom:5px; font-size:12px; }
        .info-line strong { color:#333; }

        /* Tableau paiement */
        table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        thead th { background:#00b894; color:white; padding:10px; text-align:left; font-size:11px; text-transform:uppercase; }
        tbody td { padding:10px; border-bottom:1px solid #dee2e6; font-size:12px; }
        tbody tr:last-child td { border-bottom:none; }

        /* Total */
        .total-section { text-align:right; margin-bottom:25px; }
        .total-box { display:inline-block; border:2px solid #00b894; border-radius:6px; padding:10px 20px; }
        .total-label { font-size:12px; color:#666; }
        .total-amount { font-size:24px; font-weight:700; color:#00b894; }

        /* Signatures */
        .signatures { display:table; width:100%; margin-top:30px; }
        .sig-cell { display:table-cell; text-align:center; width:50%; padding:10px; }
        .sig-line { border-top:1px solid #333; margin-top:40px; padding-top:6px; font-size:11px; color:#666; }

        /* Footer */
        .footer { text-align:center; margin-top:20px; font-size:10px; color:#999; border-top:1px solid #dee2e6; padding-top:10px; }

        /* Filigrane annule */
        .watermark { position:fixed; top:40%; left:20%; font-size:80px; color:rgba(231,76,60,0.15); font-weight:700; transform:rotate(-30deg); z-index:-1; }
    </style>
</head>
<body>

    {{-- Filigrane si annule --}}
    @if($payment->status == 'annulé')
    <div class="watermark">ANNULE</div>
    @endif

    {{-- EN-TETE --}}
    <div class="header">
        <div class="header-left">
            <div class="school-name">🎓 EduGest</div>
            <div class="school-sub">Ecole Primaire — Excellence, Discipline, Reussite</div>
        </div>
        <div class="header-right">
            <div class="facture-title">RECU DE PAIEMENT</div>
            <div class="facture-num">N° {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div style="margin-top:8px;">
                @if($payment->status == 'payé')
                    <span class="status-badge status-paye">✓ PAYE</span>
                @elseif($payment->status == 'en attente')
                    <span class="status-badge status-attente">⏳ EN ATTENTE</span>
                @else
                    <span class="status-badge status-annule">✗ ANNULE</span>
                @endif
            </div>
        </div>
    </div>

    {{-- INFOS ELEVE ET PAIEMENT --}}
    <div class="info-grid">
        <div class="info-col">
            <div class="info-box">
                <div class="info-box-title">👨‍🎓 Informations de l'eleve</div>
                <div class="info-line"><strong>Nom :</strong> {{ $payment->student->last_name ?? 'N/A' }} {{ $payment->student->first_name ?? '' }}</div>
                <div class="info-line"><strong>N° Inscription :</strong> {{ $payment->student->registration_number ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="info-col">
            <div class="info-box">
                <div class="info-box-title">📋 Informations du paiement</div>
                <div class="info-line"><strong>Date :</strong> {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</div>
                <div class="info-line"><strong>Reference :</strong> PAY-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="info-line"><strong>Emis le :</strong> {{ now()->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    {{-- DETAIL PAIEMENT --}}
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $payment->description ?? 'Frais de scolarite' }}</td>
                <td>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</td>
                <td>
                    @if($payment->status == 'payé') Paye
                    @elseif($payment->status == 'en attente') En attente
                    @else Annule
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="total-section">
        <div class="total-box">
            <div class="total-label">MONTANT TOTAL</div>
            <div class="total-amount">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    {{-- SIGNATURES --}}
    <div class="signatures">
        <div class="sig-cell">
            <div class="sig-line">Le Caissier / Responsable</div>
        </div>
        <div class="sig-cell">
            <div class="sig-line">Signature du Parent</div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Document genere le {{ now()->format('d/m/Y H:i') }} — EduGest &copy; {{ date('Y') }}<br>
        Ce document tient lieu de recu officiel de paiement.
    </div>

</body>
</html>