<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Connexion à l'espace étudiant ou administratif d'AttestPro.">
<title>Connexion | <?= APP_NAME ?></title>
<link rel="preconnect" href="https://api.fontshare.com">
<link href="https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com/css2?family=Geist+Mono:wght@400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
<div class="auth-shell">
    <div class="auth-visual">
        <div class="auth-visual-brand">
            <div class="brand-logo">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>
            <div>
                <span class="brand-name"><?= APP_NAME ?></span>
                <div class="brand-tag">Système de file d'attente</div>
            </div>
        </div>

        <div>
            <h2>Le guichet de vos attestations académiques.</h2>
            <p>Soumettez votre demande en quelques minutes, obtenez votre ticket et suivez chaque étape jusqu'au retrait.</p>

            <div class="auth-features">
                <div class="auth-feature">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <span>Suivi du statut de votre ticket en temps réel</span>
                </div>
                <div class="auth-feature">
                    <i class="bi bi-qr-code-scan"></i>
                    <span>Reçu de guichet avec code unique</span>
                </div>
                <div class="auth-feature">
                    <i class="bi bi-display-fill"></i>
                    <span>Affichage d'appel en direct sur l'écran du hall</span>
                </div>
            </div>
        </div>

        <p class="auth-quote">Fini les heures d'attente devant le bureau de la scolarité.</p>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-box">
            <h1>Connexion</h1>
            <p class="page-sub">Accédez à votre espace étudiant ou administratif.</p>

            <?php if (!empty($errors)): ?>
                <div class="error-list"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
            <?php endif; ?>

            <form method="POST" action="<?= APP_URL ?>/auth/login">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" placeholder="prenom.nom@universite.mg" autocomplete="email" required autofocus>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>

            <div class="form-note">
                <p class="auth-switch">Pas encore de compte ? <a href="<?= APP_URL ?>/auth/register">Créer un compte étudiant</a></p>
            </div>
        </div>
    </div>
</div>
<script src="<?= APP_URL ?>/assets/js/main.js"></script>
</body>
</html>
