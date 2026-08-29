<div class="page-head">
    <div>
        <p class="page-eyebrow">Fiche de Retrait Guichet</p>
        <h1>Remise officielle du document</h1>
        <p class="page-sub">Ticket <span class="mono" style="color:var(--cyan);"><?= htmlspecialchars($demande['code_demande']) ?></span></p>
    </div>
    <a href="<?= APP_URL ?>/admin/detail/<?= $demande['id'] ?>" class="btn btn-ghost">← Annuler</a>
</div>

<div class="card" style="max-width:560px;">
    <h3 style="font-size:16px;margin-bottom:16px;"><i class="bi bi-person-check-fill" style="color:var(--cyan)"></i> Informations du bénéficiaire</h3>
    
    <dl class="info-list" style="margin-bottom:24px;">
        <dt>Étudiant Titulaire</dt><dd><?= htmlspecialchars($demande['etudiant_prenom'] . ' ' . $demande['etudiant_nom']) ?></dd>
        <dt>Matricule</dt><dd class="mono"><?= htmlspecialchars($demande['matricule']) ?></dd>
        <dt>Type d'attestation</dt><dd><?= htmlspecialchars($demande['type_nom']) ?></dd>
    </dl>

    <form method="POST" action="<?= APP_URL ?>/admin/retrait/<?= $demande['id'] ?>">
        <div class="form-group">
            <label for="nom_receveur">Nom et prénom de la personne qui retire le document</label>
            <input type="text" id="nom_receveur" name="nom_receveur" value="<?= htmlspecialchars($demande['etudiant_prenom'] . ' ' . $demande['etudiant_nom']) ?>" required autofocus>
            <p class="form-hint">Si mandataire, indiquez son nom complet.</p>
        </div>
        <button type="submit" class="btn btn-accent btn-block"><i class="bi bi-box-arrow-up-right"></i> Confirmer la remise du document</button>
    </form>
</div>
