<div class="page-head">
    <div>
        <p class="page-eyebrow">Compte Étudiant</p>
        <h1>Mon profil académique</h1>
        <p class="page-sub">Gérez vos coordonnées et la sécurité de votre compte.</p>
    </div>
</div>

<?php if (!empty($errors)): ?>
    <div class="error-list">
        <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>

<div class="two-col">
    <div>
        <!-- Carte de profil -->
        <div class="card" style="margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:18px;margin-bottom:24px;">
                <div class="user-avatar" style="width:64px;height:64px;font-size:26px;">
                    <?= strtoupper(substr($user['prenom'], 0, 1)) ?>
                </div>
                <div>
                    <h2 style="font-size:22px;margin:0;"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h2>
                    <p style="color:var(--cyan);font-weight:700;margin:4px 0 0;" class="mono">Matricule : <?= htmlspecialchars($user['matricule']) ?></p>
                </div>
            </div>

            <form method="POST" action="<?= APP_URL ?>/etudiant/profil">
                <input type="hidden" name="action" value="update_info">
                
                <div class="form-group">
                    <label for="email">Adresse email (identifiant)</label>
                    <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" disabled style="opacity:0.6;cursor:not-allowed;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="filiere">Filière</label>
                        <input type="text" id="filiere" name="filiere" value="<?= htmlspecialchars($user['filiere']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="niveau">Niveau</label>
                        <input type="text" id="niveau" name="niveau" value="<?= htmlspecialchars($user['niveau']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telephone">Numéro de téléphone</label>
                    <input type="tel" id="telephone" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>" placeholder="034 XX XXX XX">
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle-fill"></i> Mettre à jour mon profil</button>
            </form>
        </div>
    </div>

    <div>
        <!-- Modification du mot de passe -->
        <div class="card">
            <h3 style="font-size:18px;margin-bottom:18px;"><i class="bi bi-shield-lock-fill" style="color:var(--cyan)"></i> Securité du compte</h3>
            
            <form method="POST" action="<?= APP_URL ?>/etudiant/profil">
                <input type="hidden" name="action" value="change_password">

                <div class="form-group">
                    <label for="old_password">Ancien mot de passe</label>
                    <input type="password" id="old_password" name="old_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">Nouveau mot de passe</label>
                    <input type="password" id="new_password" name="new_password" required placeholder="Au moins 6 caractères">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn btn-accent btn-block"><i class="bi bi-key-fill"></i> Changer de mot de passe</button>
            </form>
        </div>
    </div>
</div>
