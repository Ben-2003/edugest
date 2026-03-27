<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Bulletin Scolaire</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#333; }

        /* En-tete */
        .header { text-align:center; border-bottom:3px solid #6c5ce7; padding-bottom:15px; margin-bottom:20px; }
        .header .school-name { font-size:22px; font-weight:700; color:#6c5ce7; text-transform:uppercase; }
        .header .school-sub { font-size:12px; color:#666; margin-top:4px; }
        .header .bulletin-title { font-size:16px; font-weight:700; margin-top:10px; background:#6c5ce7; color:white; padding:6px 20px; display:inline-block; border-radius:4px; }

        /* Infos eleve */
        .info-section { display:table; width:100%; margin-bottom:20px; border:1px solid #dee2e6; border-radius:6px; overflow:hidden; }
        .info-row { display:table-row; }
        .info-cell { display:table-cell; padding:8px 12px; border-bottom:1px solid #dee2e6; width:50%; }
        .info-label { font-weight:700; color:#6c5ce7; font-size:11px; text-transform:uppercase; }
        .info-value { font-size:13px; margin-top:2px; }

        /* Tableau des notes */
        .notes-title { font-size:14px; font-weight:700; color:#6c5ce7; border-bottom:2px solid #6c5ce7; padding-bottom:6px; margin-bottom:12px; }
        table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        thead th { background:#6c5ce7; color:white; padding:8px 10px; text-align:left; font-size:11px; text-transform:uppercase; }
        tbody td { padding:8px 10px; border-bottom:1px solid #dee2e6; font-size:12px; }
        tbody tr:nth-child(even) { background:#f8f9fa; }
        tbody tr:last-child td { border-bottom:none; }

        /* Badge note */
        .note-badge { display:inline-block; padding:3px 8px; border-radius:4px; font-weight:700; font-size:12px; }
        .note-good { background:#d4edda; color:#155724; }
        .note-bad  { background:#f8d7da; color:#721c24; }

        /* Synthese */
        .synthese { border:2px solid #6c5ce7; border-radius:6px; padding:15px; margin-bottom:20px; }
        .synthese-title { font-size:13px; font-weight:700; color:#6c5ce7; margin-bottom:10px; }
        .synthese-grid { display:table; width:100%; }
        .synthese-row { display:table-row; }
        .synthese-cell { display:table-cell; padding:6px 10px; width:33%; text-align:center; border-right:1px solid #dee2e6; }
        .synthese-cell:last-child { border-right:none; }
        .synthese-number { font-size:20px; font-weight:700; color:#6c5ce7; }
        .synthese-label { font-size:10px; color:#666; text-transform:uppercase; margin-top:2px; }

        /* Appreciation */
        .appreciation { border:1px solid #dee2e6; border-radius:6px; padding:12px; margin-bottom:20px; }
        .appreciation-title { font-weight:700; color:#333; margin-bottom:6px; font-size:12px; }
        .appreciation-text { font-size:12px; color:#555; font-style:italic; }

        /* Signatures */
        .signatures { display:table; width:100%; margin-top:30px; }
        .sig-cell { display:table-cell; text-align:center; width:33%; padding:10px; }
        .sig-line { border-top:1px solid #333; margin-top:40px; padding-top:6px; font-size:11px; color:#666; }

        /* Pied de page */
        .footer { text-align:center; margin-top:20px; font-size:10px; color:#999; border-top:1px solid #dee2e6; padding-top:10px; }

        /* Mention */
        .mention { display:inline-block; padding:4px 12px; border-radius:4px; font-weight:700; font-size:13px; }
        .mention-excellent { background:#d4edda; color:#155724; }
        .mention-bien      { background:#cce5ff; color:#004085; }
        .mention-moyen     { background:#fff3cd; color:#856404; }
        .mention-faible    { background:#f8d7da; color:#721c24; }
    </style>
</head>
<body>

    {{-- EN-TETE --}}
    <div class="header">
        <div class="school-name">🎓 EduGest — Ecole Primaire</div>
        <div class="school-sub">Excellence, Discipline, Reussite</div>
        <div class="bulletin-title">BULLETIN SCOLAIRE — {{ strtoupper($reportCard->term) }}</div>
    </div>

    {{-- INFOS ELEVE --}}
    <div class="info-section">
        <div class="info-row">
            <div class="info-cell">
                <div class="info-label">Nom et Prenom</div>
                <div class="info-value">{{ $reportCard->student->last_name ?? '' }} {{ $reportCard->student->first_name ?? '' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Numero d'inscription</div>
                <div class="info-value">{{ $reportCard->student->registration_number ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="info-row">
            <div class="info-cell">
                <div class="info-label">Classe</div>
                <div class="info-value">{{ $reportCard->schoolClass->class_name ?? 'N/A' }}</div>
            </div>
            <div class="info-cell">
                <div class="info-label">Annee scolaire</div>
                <div class="info-value">{{ $reportCard->schoolYear->year_name ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    {{-- TABLEAU DES NOTES --}}
    <div class="notes-title">📚 Detail des notes</div>
    @if($grades->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Matiere</th>
                <th>Note /20</th>
                <th>Type</th>
                <th>Appreciation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
            @php
                $mention = match(true) {
                    $grade->score >= 16 => 'Tres bien',
                    $grade->score >= 14 => 'Bien',
                    $grade->score >= 12 => 'Assez bien',
                    $grade->score >= 10 => 'Passable',
                    default             => 'Insuffisant'
                };
            @endphp
            <tr>
                <td>{{ $grade->subject->subject_name ?? 'N/A' }}</td>
                <td>
                    <span class="note-badge {{ $grade->score >= 10 ? 'note-good' : 'note-bad' }}">
                        {{ number_format($grade->score, 2) }}/20
                    </span>
                </td>
                <td>{{ $grade->grade_type ?? 'N/A' }}</td>
                <td>{{ $mention }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="color:#999;font-style:italic;margin-bottom:20px;">Aucune note enregistree pour ce trimestre.</p>
    @endif

    {{-- SYNTHESE --}}
    @php
        $avg = $reportCard->average ?? 0;
        $mentionClass = match(true) {
            $avg >= 16 => 'mention-excellent',
            $avg >= 12 => 'mention-bien',
            $avg >= 10 => 'mention-moyen',
            default    => 'mention-faible'
        };
        $mentionText = match(true) {
            $avg >= 16 => 'Tres bien',
            $avg >= 14 => 'Bien',
            $avg >= 12 => 'Assez bien',
            $avg >= 10 => 'Passable',
            default    => 'Insuffisant'
        };
    @endphp
    <div class="synthese">
        <div class="synthese-title">📊 Synthese du trimestre</div>
        <div class="synthese-grid">
            <div class="synthese-row">
                <div class="synthese-cell">
                    <div class="synthese-number">{{ number_format($avg, 2) }}/20</div>
                    <div class="synthese-label">Moyenne generale</div>
                </div>
                <div class="synthese-cell">
                    <div class="synthese-number">{{ $reportCard->rank ?? 'N/A' }}</div>
                    <div class="synthese-label">Rang dans la classe</div>
                </div>
                <div class="synthese-cell">
                    <span class="mention {{ $mentionClass }}">{{ $mentionText }}</span>
                    <div class="synthese-label" style="margin-top:6px;">Mention</div>
                </div>
            </div>
        </div>
    </div>

    {{-- APPRECIATION --}}
    @if($reportCard->appreciation || $reportCard->remarks)
    <div class="appreciation">
        <div class="appreciation-title">💬 Appreciation du conseil de classe</div>
        <div class="appreciation-text">{{ $reportCard->appreciation ?? $reportCard->remarks ?? '—' }}</div>
    </div>
    @endif

    {{-- SIGNATURES --}}
    <div class="signatures">
        <div class="sig-cell">
            <div class="sig-line">Le Directeur</div>
        </div>
        <div class="sig-cell">
            <div class="sig-line">L'Enseignant(e)</div>
        </div>
        <div class="sig-cell">
            <div class="sig-line">Signature du Parent</div>
        </div>
    </div>

    {{-- PIED DE PAGE --}}
    <div class="footer">
        Document genere le {{ now()->format('d/m/Y') }} — EduGest &copy; {{ date('Y') }}
    </div>

</body>
</html>