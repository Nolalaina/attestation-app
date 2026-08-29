<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion — <?= APP_NAME ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
<div class="auth-shell">
    <div class="auth-visual">
        <div class="auth-visual-brand">
            <div class="brand-logo" style="width:48px;height:48px;font-size:24px;border-radius:14px;">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
            <div>
                <span class="brand-name" style="font-size:24px;"><?= APP_NAME ?></span>
                <div class="brand-tag">Système de File d'Attente</div>
            </div>
        </div>

        <div>
            <h2 style="font-size:38px;font-weight:900;line-height:1.2;margin-bottom:20px;">
                Le guichet digital de vos attestations académiques.
            </h2>
            <p style="font-size:16.5px;color:var(--text-muted);max-width:480px;line-height:1.6;margin-bottom:32px;">
                Soumettez votre demande en quelques secondes, obtenez votre ticket de file d'attente sécurisé et suivez chaque étape jusqu'au retrait.
            </p>

            <div style="display:flex;flex-direction:column;gap:14px;max-width:440px;">
                <div style="display:flex;align-items:center;gap:14px;background:rgba(255,255,255,0.04);padding:14px 18px;border-radius:14px;border:1px solid rgba(255,255,255,0.08);">
                    <i class="bi bi-lightning-charge-fill" style="color:var(--cyan);font-size:22px;"></i>
                    <span style="font-size:14.5px;font-weight:600;">Suivi du statut de ticket en temps réel</span>
                </div>
                <div style="display:flex;align-items:center;gap:14px;background:rgba(255,255,255,0.04);padding:14px 18px;border-radius:14px;border:1px solid rgba(255,255,255,0.08);">
                    <i class="bi bi-qr-code-scan" style="color:var(--primary);font-size:22px;"></i>
                    <span style="font-size:14.5px;font-weight:600;">Reçu de guichet avec code unique</span>
                </div>
                <div style="display:flex;align-items:center;gap:14px;background:rgba(255,255,255,0.04);padding:14px 18px;border-radius:14px;border:1px solid rgba(255,255,255,0.08);">
                    <i class="bi bi-display-fill" style="color:#10b981;font-size:22px;"></i>
                    <span style="font-size:14.5px;font-weight:600;">Affichage d'appel en direct sur écran de hall</span>
                </div>
            </div>
        </div>

        <p class="auth-quote">« Fini les heures d'attente physiques devant le bureau de la scolarité. »</p>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-box">
            <div style="display:inline-block;padding:6px 14px;background:rgba(6,182,212,0.12);border:1px solid rgba(6,182,212,0.3);color:var(--cyan);border-radius:999px;font-size:12px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:14px;">
                Espace Personnel & Guichet
            </div>
            <h1>Connexion</h1>
            <p class="page-sub">Accédez à votre espace étudiant ou administratif.</p>

            <?php if (!empty($errors)): ?>
                <div class="error-list"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
            <?php endif; ?>

            <form method="POST" action="<?= APP_URL ?>/auth/login">
                <div class="form-group">
                    <label for="email"><i class="bi bi-envelope-fill" style="color:var(--cyan)"></i> Adresse email</label>
                    <input type="email" id="email" name="email" placeholder="ex. admin@universite.mg ou etudiant@universite.mg" required autofocus>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe"><i class="bi bi-lock-fill" style="color:var(--cyan)"></i> Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>
            </form>

            <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--line-border);text-align:center;">
                <p class="auth-switch" style="margin:0;">
                    Pas encore de compte ? <a href="<?= APP_URL ?>/auth/register" style="color:var(--cyan);font-weight:800;">Créer un compte étudiant →</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="<?= APP_URL ?>/assets/js/main.js"></script>
</body>
</html>
