<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Guichet N° <?= htmlspecialchars($demande['code_demande']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@600;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }
        .btn {
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
        }
        .btn-ghost {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .ticket-card {
            background: #1e293b;
            border: 2px dashed #334155;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            padding: 32px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            position: relative;
            overflow: hidden;
        }
        .ticket-card::before, .ticket-card::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 24px;
            height: 24px;
            background: #0f172a;
            border-radius: 50%;
            transform: translateY(-50%);
        }
        .ticket-card::before { left: -12px; }
        .ticket-card::after { right: -12px; }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #334155;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
        }
        .header p {
            font-size: 12px;
            color: #06b6d4;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 700;
            margin-top: 4px;
        }
        .ticket-code-box {
            text-align: center;
            background: rgba(6, 182, 212, 0.1);
            border: 1px solid rgba(6, 182, 212, 0.3);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .ticket-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            font-weight: 700;
        }
        .ticket-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 30px;
            font-weight: 800;
            color: #38bdf8;
            letter-spacing: 0.05em;
            margin-top: 4px;
        }
        .barcode {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3px;
            height: 36px;
            margin-top: 10px;
        }
        .barcode div {
            background: #f8fafc;
            height: 100%;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        .detail-item dt {
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
        }
        .detail-item dd {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-top: 2px;
        }
        .footer-note {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #334155;
            padding-top: 16px;
        }
        @media print {
            .no-print { display: none; }
            body { background: #fff; color: #000; padding: 0; }
            .ticket-card { background: #fff; color: #000; border-color: #000; box-shadow: none; }
            .ticket-code { color: #000; }
            .barcode div { background: #000; }
            .header h1, .detail-item dd { color: #000; }
            .header p, .ticket-label, .detail-item dt, .footer-note { color: #444; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn">🖨️ Imprimer le ticket</button>
        <button onclick="window.history.back()" class="btn btn-ghost">← Retour</button>
    </div>

    <div class="ticket-card">
        <div class="header">
            <h1><?= APP_NAME ?></h1>
            <p>Ticket de Guichet & Reçu de Demande</p>
        </div>

        <div class="ticket-code-box">
            <div class="ticket-label">N° DE TICKET DE FILE D'ATTENTE</div>
            <div class="ticket-code"><?= htmlspecialchars($demande['code_demande']) ?></div>
            <div class="barcode">
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
                <dt>Statut Actuel</dt>
                <dd><?= strtoupper(str_replace('_', ' ', $demande['statut'])) ?></dd>
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
            <strong>Merci de vous munir d'une pièce d'identité valide.</strong>
        </div>
    </div>
</body>
</html>
