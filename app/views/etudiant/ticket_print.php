<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ticket de guichet à présenter lors du retrait de l'attestation.">
    <title>Ticket guichet N° <?= htmlspecialchars($demande['code_demande']) ?></title>
    <link rel="preconnect" href="https://api.fontshare.com">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: clip; }
        body {
            font-family: "General Sans", system-ui, -apple-system, sans-serif;
            background: oklch(96.2% 0.008 252);
            color: oklch(21% 0.028 262);
            display: flex; justify-content: center; align-items: center;
            min-height: 100dvh; padding: 20px;
        }
        :focus-visible { outline: 2px solid oklch(52% 0.19 258); outline-offset: 2px; }
        .no-print { position: fixed; top: 20px; right: 20px; display: flex; gap: 10px; z-index: 100; }
        .btn {
            background: oklch(21% 0.024 262); color: oklch(93% 0.010 250);
            padding: 10px 20px; border-radius: 8px; text-decoration: none;
            font-weight: 500; font-size: 14px; border: none; cursor: pointer;
            min-height: 44px; display: inline-flex; align-items: center;
        }
        .btn-ghost {
            background: transparent; color: oklch(21% 0.028 262);
            border: 1px solid oklch(83% 0.012 252);
        }
        .ticket-card {
            background: oklch(99.4% 0.003 250);
            border: 1px dashed oklch(83% 0.012 252);
            border-radius: 8px; width: 100%; max-width: 480px;
            padding: 32px; position: relative; overflow: hidden;
        }
        .header { text-align: center; border-bottom: 1px solid oklch(90% 0.009 252); padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { font-size: 22px; font-weight: 600; }
        .header p { font-size: 14px; color: oklch(50% 0.018 258); margin-top: 4px; }
        .ticket-code-box {
            text-align: center; border: 1px solid oklch(90% 0.009 252);
            border-radius: 8px; padding: 16px; margin-bottom: 24px; background: oklch(98.6% 0.005 250);
        }
        .ticket-label { font-size: 14px; color: oklch(50% 0.018 258); }
        .ticket-code {
            font-family: "Geist Mono", ui-monospace, monospace;
            font-size: 30px; font-variant-numeric: tabular-nums; margin-top: 4px;
        }
        .barcode { display: flex; justify-content: center; align-items: center; gap: 3px; height: 36px; margin-top: 10px; }
        .barcode div { background: oklch(21% 0.028 262); height: 100%; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .detail-item dt { font-size: 14px; color: oklch(50% 0.018 258); }
        .detail-item dd { font-size: 14px; font-weight: 600; margin-top: 2px; overflow-wrap: break-word; min-width: 0; }
        .footer-note {
            text-align: center; font-size: 14px; color: oklch(50% 0.018 258);
            border-top: 1px solid oklch(90% 0.009 252); padding-top: 16px;
        }
        @media print {
            .no-print { display: none; }
            body { background: oklch(99.4% 0.003 250); padding: 0; }
            .ticket-card { background: oklch(99.4% 0.003 250); border-color: oklch(21% 0.028 262); }
        }
        @media (prefers-reduced-motion: reduce) { * { transition: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn" type="button">Imprimer le ticket</button>
        <button onclick="window.history.back()" class="btn btn-ghost" type="button">Retour</button>
    </div>

    <div class="ticket-card">
        <div class="header">
            <h1><?= APP_NAME ?></h1>
            <p>Ticket de guichet et reçu de demande</p>
        </div>

        <div class="ticket-code-box">
            <div class="ticket-label">N° de ticket de file d'attente</div>
            <div class="ticket-code"><?= htmlspecialchars($demande['code_demande']) ?></div>
            <div class="barcode" aria-hidden="true">
                <div style="width:3px"></div><div style="width:1px"></div><div style="width:4px"></div>
                <div style="width:2px"></div><div style="width:5px"></div><div style="width:1px"></div>
                <div style="width:3px"></div><div style="width:2px"></div><div style="width:4px"></div>
                <div style="width:1px"></div><div style="width:3px"></div><div style="width:6px"></div>
                <div style="width:2px"></div><div style="width:4px"></div><div style="width:2px"></div>
            </div>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <dt>Étudiant</dt>
                <dd><?= htmlspecialchars($demande['etudiant_prenom'] . ' ' . $demande['etudiant_nom']) ?></dd>
            </div>
            <div class="detail-item">
                <dt>Matricule</dt>
                <dd><?= htmlspecialchars($demande['matricule']) ?></dd>
            </div>
            <div class="detail-item">
                <dt>Type de document</dt>
                <dd><?= htmlspecialchars($demande['type_nom']) ?></dd>
            </div>
            <div class="detail-item">
                <dt>Statut actuel</dt>
                <dd><?= ucfirst(str_replace('_', ' ', $demande['statut'])) ?></dd>
            </div>
            <div class="detail-item">
                <dt>Date de soumission</dt>
                <dd><?= date('d/m/Y H:i', strtotime($demande['date_demande'])) ?></dd>
            </div>
            <div class="detail-item">
                <dt>Retrait prévu le</dt>
                <dd><?= $demande['date_prevue_retrait'] ? date('d/m/Y', strtotime($demande['date_prevue_retrait'])) : 'En attente' ?></dd>
            </div>
        </div>

        <div class="footer-note">
            Présentez ce ticket au guichet administratif lors du retrait de votre document.<br>
            <strong>Munissez-vous d'une pièce d'identité valide.</strong>
        </div>
    </div>
</body>
</html>
