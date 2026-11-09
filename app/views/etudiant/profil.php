<div class="page-head">
    <div>
        <p class="page-eyebrow">Compte étudiant</p>
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
    <div class="card">
        <div class="profile-head">
            <div class="user-avatar avatar-lg">
                <?= strtoupper(substr($user['prenom'], 0, 1)) ?>
            </div>
            <div class="grow">
                <h2><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h2>
                <p class="mono">Matricule : <?= htmlspecialchars($user['matricule']) ?></p>
            </div>
        </div>

        <form method="POST" action="<?= APP_URL ?>/etudiant/profil">
            <input type="hidden" name="action" value="update_info">

            <div class="form-group">
                <label for="email">Adresse email (identifiant)</label>
                <input type="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
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

            <button type="submit" class="btn btn-primary">Mettre à jour mon profil</button>
        </form>
    </div>

    <div class="card">
        <h3>Sécurité du compte</h3>

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

            <button type="submit" class="btn btn-accent btn-block">Changer de mot de passe</button>
        </form>
    </div>
</div>
