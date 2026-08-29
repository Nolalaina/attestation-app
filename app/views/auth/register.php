<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer un compte — <?= APP_NAME ?></title>
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
                Inscrivez-vous en 2 minutes et suivez vos attestations à distance.
            </h2>
            <p style="font-size:16.5px;color:var(--text-muted);max-width:480px;line-height:1.6;">
                Enregistrez vos informations académiques une seule fois pour soumettre vos demandes de certificats de scolarité, relevés de notes et attestations en ligne.
            </p>
        </div>

        <p class="auth-quote">« Un processus simple, transparent et numérisé pour tous les étudiants. »</p>
    </div>

    <div class="auth-form-side">
        <div class="auth-form-box" style="max-width:540px;">
            <div style="display:inline-block;padding:6px 14px;background:rgba(6,182,212,0.12);border:1px solid rgba(6,182,212,0.3);color:var(--cyan);border-radius:999px;font-size:12px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:14px;">
                Inscription Étudiant
            </div>
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
                        <label for="matricule">Numéro Matricule</label>
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
                        <input type="text" id="filiere" name="filiere" value="<?= htmlspecialchars($old['filiere'] ?? '') ?>" placeholder="ex. Informatique de Gestion" required>
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
                        <input type="password" id="mot_de_passe_confirm" name="mot_de_passe_confirm" required placeholder="Répéter mot de passe">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-person-plus-fill"></i> Créer mon compte étudiant</button>
            </form>

            <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--line-border);text-align:center;">
                <p class="auth-switch" style="margin:0;">
                    Vous avez déjà un compte ? <a href="<?= APP_URL ?>/auth/login" style="color:var(--cyan);font-weight:800;">Se connecter →</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="<?= APP_URL ?>/assets/js/main.js"></script>
</body>
</html>
