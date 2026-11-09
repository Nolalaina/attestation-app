<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Écran d'appel des tickets au guichet administratif.">
    <title>Écran de guichet | <?= APP_NAME ?></title>
    <link rel="preconnect" href="https://api.fontshare.com">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { overflow-x: clip; }
        body {
            font-family: "General Sans", system-ui, -apple-system, sans-serif;
            background-color: oklch(21% 0.024 262);
            color: oklch(93% 0.010 250);
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
        }
        :focus-visible { outline: 2px solid oklch(52% 0.19 258); outline-offset: 2px; }
        header {
            border-bottom: 1px solid oklch(40% 0.022 260);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .brand { display: flex; align-items: center; gap: 16px; min-width: 0; }
        .brand-logo {
            width: 48px; height: 48px; border-radius: 8px;
            background: oklch(93% 0.010 250);
            color: oklch(21% 0.024 262);
            display: grid; place-items: center; font-size: 22px; flex-shrink: 0;
        }
        .brand-text h1 { font-size: 24px; font-weight: 600; letter-spacing: -0.02em; }
        .brand-text p { font-size: 14px; color: oklch(69% 0.022 256); margin-top: 4px; }
        .clock-box {
            font-family: "Geist Mono", ui-monospace, monospace;
            font-size: 32px; font-variant-numeric: tabular-nums;
            padding: 8px 24px; border-radius: 8px;
            border: 1px solid oklch(40% 0.022 260);
        }
        .main-grid { flex: 1; display: grid; grid-template-columns: 1.2fr 1fr; gap: 32px; padding: 32px 40px; }
        .column { border: 1px solid oklch(40% 0.022 260); border-radius: 8px; padding: 32px; display: flex; flex-direction: column; }
        .col-title { font-size: 18px; font-weight: 600; margin-bottom: 24px; }
        .ticket-list { display: flex; flex-direction: column; gap: 16px; }
        .ticket-list-spaced { margin-bottom: 32px; }
        .ticket-card-called {
            border: 2px solid oklch(93% 0.010 250);
            border-radius: 8px; padding: 20px 24px;
            display: flex; justify-content: space-between; align-items: center; gap: 16px;
        }
        .ticket-code { font-family: "Geist Mono", ui-monospace, monospace; font-size: 32px; font-variant-numeric: tabular-nums; }
        .ticket-code-small { font-size: 20px; }
        .ticket-code-sm2 { font-size: 18px; }
        .ticket-type { font-size: 13px; color: oklch(69% 0.022 256); margin-top: 4px; }
        .ticket-meta { text-align: right; min-width: 0; }
        .guichet-badge {
            background: oklch(93% 0.010 250); color: oklch(21% 0.024 262);
            padding: 6px 16px; border-radius: 999px; font-weight: 600; font-size: 14px; display: inline-block;
        }
        .ticket-name { font-size: 18px; font-weight: 600; margin-top: 6px; }
        .ticket-card-small {
            border: 1px solid oklch(40% 0.022 260); border-radius: 8px;
            padding: 14px 20px; display: flex; justify-content: space-between; align-items: center; gap: 16px;
        }
        .empty-note { color: oklch(69% 0.022 256); font-size: 16px; }
        footer {
            border-top: 1px solid oklch(40% 0.022 260);
            padding: 16px 40px; display: flex; justify-content: space-between; align-items: center;
            gap: 16px; flex-wrap: wrap; font-size: 14px; color: oklch(69% 0.022 256);
        }
        @media (max-width: 860px) { .main-grid { grid-template-columns: 1fr; padding: 20px; } header, footer { padding: 16px 20px; } }
        @media (prefers-reduced-motion: reduce) { * { animation: none; } }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            <div class="brand-logo" aria-hidden="true">A</div>
            <div class="brand-text">
                <h1><?= APP_NAME ?></h1>
                <p>Écran de guichet et appel des tickets</p>
            </div>
        </div>
        <div class="clock-box" id="hall-clock">--:--:--</div>
    </header>

    <div class="main-grid">
        <div class="column">
            <div class="col-title">
                <span>Tickets prêts pour retrait</span>
            </div>
            <div class="ticket-list">
                <?php if (empty($appelees)): ?>
                    <p class="empty-note">Aucun ticket prêt actuellement.</p>
                <?php else: ?>
                    <?php foreach ($appelees as $d): ?>
                    <div class="ticket-card-called">
                        <div>
                            <div class="ticket-code"><?= htmlspecialchars($d['code_demande']) ?></div>
                            <div class="ticket-type"><?= htmlspecialchars($d['type_nom']) ?></div>
                        </div>
                        <div class="ticket-meta">
                            <div class="guichet-badge">Guichet retrait</div>
                            <div class="ticket-name"><?= htmlspecialchars($d['etudiant_prenom'] . ' ' . $d['etudiant_nom']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="column">
            <div class="col-title">
                <span>Tickets en cours de traitement</span>
            </div>
            <div class="ticket-list ticket-list-spaced">
                <?php if (empty($enCours)): ?>
                    <p class="empty-note">Aucun ticket en cours de traitement.</p>
                <?php else: ?>
                    <?php foreach ($enCours as $d): ?>
                    <div class="ticket-card-small">
                        <span class="ticket-code ticket-code-small"><?= htmlspecialchars($d['code_demande']) ?></span>
                        <span><?= htmlspecialchars($d['type_nom']) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-title">
                <span>Prochains tickets en attente</span>
            </div>
            <div class="ticket-list">
                <?php if (empty($enAttente)): ?>
                    <p class="empty-note">File d'attente vide.</p>
                <?php else: ?>
                    <?php foreach ($enAttente as $d): ?>
                    <div class="ticket-card-small">
                        <span class="ticket-code ticket-code-sm2"><?= htmlspecialchars($d['code_demande']) ?></span>
                        <span><?= date('H:i', strtotime($d['date_demande'])) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <span>Présentez-vous au guichet lorsque votre numéro s'affiche sur cet écran.</span>
        <span>Rafraîchissement automatique, le <?= date('d/m/Y') ?></span>
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
        setTimeout(function() { window.location.reload(); }, 10000);
    </script>
</body>
</html>
