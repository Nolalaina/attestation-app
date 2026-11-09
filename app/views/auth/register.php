<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Création d'un compte étudiant pour demander une attestation en ligne.">
<title>Créer un compte | <?= APP_NAME ?></title>
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
            <h2>Inscrivez-vous en 2 minutes.</h2>
            <p>Enregistrez vos informations académiques une seule fois pour soumettre vos demandes de certificats et attestations.</p>
        </div>

        <p class="auth-quote">Un processus simple et transparent pour tous les étudiants.</p>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-box wide">
            <h1>Créer un compte</h1>
            <p class="page-sub">Ces informations figureront sur vos tickets de demande.</p>

            <?php if (!empty($errors)): ?>
                <div class="error-list"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
            <?php endif; ?>

            <form method="POST" action="<?= APP_URL ?>/auth/register">
                <div class="form-row">
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($old['prenom'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($old['nom'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse email académique</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" placeholder="prenom.nom@universite.mg" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="matricule">Numéro de matricule</label>
                        <input type="text" id="matricule" name="matricule" value="<?= htmlspecialchars($old['matricule'] ?? '') ?>" placeholder="ex. 2024-INF-012" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($old['telephone'] ?? '') ?>" placeholder="034 XX XXX XX">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="filiere">Filière</label>
                        <input type="text" id="filiere" name="filiere" value="<?= htmlspecialchars($old['filiere'] ?? '') ?>" placeholder="ex. Informatique de gestion" required>
                    </div>
                    <div class="form-group">
                        <label for="niveau">Niveau</label>
                        <input type="text" id="niveau" name="niveau" value="<?= htmlspecialchars($old['niveau'] ?? '') ?>" placeholder="ex. L3" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required placeholder="Au moins 6 caractères">
                    </div>
                    <div class="form-group">
                        <label for="mot_de_passe_confirm">Confirmation</label>
                        <input type="password" id="mot_de_passe_confirm" name="mot_de_passe_confirm" required placeholder="Répéter le mot de passe">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Créer mon compte étudiant</button>
            </form>

            <div class="form-note">
                <p class="auth-switch">Vous avez déjà un compte ? <a href="<?= APP_URL ?>/auth/login">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>
<script src="<?= APP_URL ?>/assets/js/main.js"></script>
</body>
</html>
