<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page introuvable — <?= APP_NAME ?></title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:10px;text-align:center;padding:20px;">
    <div class="stamp st-refusee" style="width:110px;height:110px;font-size:13px;">404</div>
    <h1 style="color:var(--ink);margin-top:14px;">Page introuvable</h1>
    <p style="color:var(--muted);max-width:360px;">Cette page n'existe pas ou a été déplacée.</p>
    <a href="<?= APP_URL ?>/auth/login" class="btn btn-primary" style="margin-top:10px;">Retour à l'accueil</a>
</div>
</body>
</html>
