<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Écran de Guichet — <?= APP_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800;900&family=JetBrains+Mono:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #090d16;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        header {
            background: rgba(15, 23, 42, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .brand-logo {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            display: grid;
            place-items: center;
            font-size: 24px;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4);
        }
        .brand-text h1 {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.02em;
        }
        .brand-text p {
            font-size: 13px;
            color: #06b6d4;
            font-weight: 700;
            text-transform: uppercase;
        }
        .clock-box {
            font-family: 'JetBrains Mono', monospace;
            font-size: 32px;
            font-weight: 800;
            color: #38bdf8;
            background: #1e293b;
            padding: 8px 24px;
            border-radius: 14px;
            border: 1px solid rgba(56, 189, 248, 0.2);
        }
        .main-grid {
            flex: 1;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 32px;
            padding: 32px 40px;
        }
        .column {
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 32px;
            display: flex;
            flex-direction: column;
        }
        .col-title {
            font-size: 18px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .col-title.green { color: #10b981; }
        .col-title.cyan { color: #06b6d4; }
        .col-title.amber { color: #f59e0b; }

        .ticket-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .ticket-card-called {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(6, 182, 212, 0.1));
            border: 2px solid #10b981;
            border-radius: 16px;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.2);
            animation: pulseCard 2s infinite ease-in-out;
        }
        @keyframes pulseCard {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .ticket-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
        }
        .ticket-meta {
            text-align: right;
        }
        .ticket-name {
            font-size: 18px;
            font-weight: 700;
            color: #ffffff;
        }
        .ticket-type {
            font-size: 13px;
            color: #94a3b8;
        }
        .guichet-badge {
            background: #10b981;
            color: #090d16;
            padding: 6px 16px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 14px;
            text-transform: uppercase;
        }
        .ticket-card-small {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        footer {
            background: #0f172a;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            <div class="brand-logo">🎟️</div>
            <div class="brand-text">
                <h1><?= APP_NAME ?></h1>
                <p>Écran de Guichet & Appel de Tickets</p>
            </div>
        </div>
        <div class="clock-box" id="hall-clock">--:--:--</div>
    </header>

    <div class="main-grid">
        <div class="column">
            <div class="col-title green">
                <span>🔔 TICKETS PRÊTS POUR RETRAIT (GUICHET)</span>
            </div>
            <div class="ticket-list">
                <?php if (empty($appelees)): ?>
                    <p style="color:#64748b;font-size:16px;">Aucun ticket prêt actuellement.</p>
                <?php else: ?>
                    <?php foreach ($appelees as $d): ?>
                    <div class="ticket-card-called">
                        <div>
                            <div class="ticket-code"><?= htmlspecialchars($d['code_demande']) ?></div>
                            <div class="ticket-type"><?= htmlspecialchars($d['type_nom']) ?></div>
                        </div>
                        <div class="ticket-meta">
                            <div class="guichet-badge">GUICHET RETRAIT</div>
                            <div class="ticket-name" style="margin-top:6px;"><?= htmlspecialchars($d['etudiant_prenom'] . ' ' . $d['etudiant_nom']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="column">
            <div class="col-title cyan">
                <span>⚙️ TICKETS EN COURS DE TRAITEMENT</span>
            </div>
            <div class="ticket-list" style="margin-bottom:32px;">
                <?php if (empty($enCours)): ?>
                    <p style="color:#64748b;font-size:15px;">Aucun ticket en cours de traitement.</p>
                <?php else: ?>
                    <?php foreach ($enCours as $d): ?>
                    <div class="ticket-card-small">
                        <span class="ticket-code" style="font-size:20px;color:#06b6d4;"><?= htmlspecialchars($d['code_demande']) ?></span>
                        <span style="font-size:14px;color:#cbd5e1;"><?= htmlspecialchars($d['type_nom']) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-title amber">
                <span>⏳ PROCHAINS TICKETS EN ATTENTE</span>
            </div>
            <div class="ticket-list">
                <?php if (empty($enAttente)): ?>
                    <p style="color:#64748b;font-size:15px;">File d'attente vide.</p>
                <?php else: ?>
                    <?php foreach ($enAttente as $d): ?>
                    <div class="ticket-card-small">
                        <span class="ticket-code" style="font-size:18px;color:#f59e0b;"><?= htmlspecialchars($d['code_demande']) ?></span>
                        <span style="font-size:13.5px;color:#94a3b8;"><?= date('H:i', strtotime($d['date_demande'])) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <span>Veuillez vous présenter au guichet lorsque votre numéro de ticket s'affiche sur cet écran.</span>
        <span>Rafraîchissement automatique • <?= date('d/m/Y') ?></span>
    </footer>

    <script>
        function updateClock() {
            var now = new Date();
            document.getElementById('hall-clock').textContent = 
                String(now.getHours()).padStart(2, '0') + ':' + 
                String(now.getMinutes()).padStart(2, '0') + ':' + 
                String(now.getSeconds()).padStart(2, '0');
        }
        setInterval(updateClock, 1000);
        updateClock();
        // Auto-refresh hall display screen every 10 seconds
        setTimeout(function() { window.location.reload(); }, 10000);
    </script>
</body>
</html>
