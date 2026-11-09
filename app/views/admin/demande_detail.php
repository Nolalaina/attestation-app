<div class="page-head">
    <div>
        <p class="page-eyebrow">Traitement au guichet</p>
        <h1 class="mono"><?= htmlspecialchars($demande['code_demande']) ?></h1>
        <p class="page-sub">Soumise le <?= date('d/m/Y à H:i', strtotime($demande['date_demande'])) ?></p>
    </div>
    <div class="col-actions">
        <a href="<?= APP_URL ?>/admin/ticket/<?= $demande['id'] ?>" target="_blank" rel="noopener" class="btn btn-accent">Imprimer le ticket</a>
        <a href="<?= APP_URL ?>/admin/registre" class="btn btn-ghost">Retour au registre</a>
    </div>
</div>

<div class="two-col">
    <div>
        <div class="card row-between">
            <div class="stamp st-<?= $demande['statut'] ?>"><?= strtoupper(str_replace('_', "\n", $demande['statut'])) ?></div>
            <div class="grow">
                <h3><?= htmlspecialchars($demande['type_nom']) ?></h3>
                <p class="page-sub"><?= htmlspecialchars($demande['objet']) ?></p>

                <?php if ($demande['observations']): ?>
                    <div class="timeline-comment">
                        <strong>Observations de l'étudiant :</strong> <?= htmlspecialchars($demande['observations']) ?>
                    </div>
                <?php endif; ?>

                <?php if ($demande['statut'] === 'refusee'): ?>
                    <div class="error-list"><strong>Motif du refus :</strong> <?= htmlspecialchars($demande['motif_refus']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!in_array($demande['statut'], ['retiree'], true)): ?>
        <div class="card">
            <h3>Mettre à jour le statut</h3>
            <form method="POST" action="<?= APP_URL ?>/admin/changerStatut/<?= $demande['id'] ?>">
                <div class="form-group">
                    <label for="statut">Nouveau statut</label>
                    <select id="statut" name="statut" data-statut-select="#motif-box">
                        <?php if ($demande['statut'] === 'en_attente'): ?>
                            <option value="en_cours">Prendre en charge (en cours)</option>
                        <?php endif; ?>
                        <?php if (in_array($demande['statut'], ['en_attente', 'en_cours'], true)): ?>
                            <option value="traitee">Marquer comme traitée et prête au guichet</option>
                            <option value="refusee">Refuser la demande</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group" id="motif-box" style="display:none;">
                    <label for="commentaire">Motif du refus</label>
                    <textarea id="commentaire" name="commentaire" placeholder="Expliquez la raison du refus pour l'étudiant"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Valider le changement</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($demande['statut'] === 'traitee'): ?>
        <div class="card">
            <h3>Document prêt pour retrait</h3>
            <p class="page-sub">L'attestation a été imprimée et visée. Enregistrez le retrait dès que l'étudiant se présente.</p>
            <a href="<?= APP_URL ?>/admin/retrait/<?= $demande['id'] ?>" class="btn btn-accent">Enregistrer la remise du document</a>
        </div>
        <?php endif; ?>

        <?php if ($retrait): ?>
        <div class="flash flash-success">
            <span>Document remis à <strong><?= htmlspecialchars($retrait['nom_receveur']) ?></strong> le <?= date('d/m/Y à H:i', strtotime($retrait['date_retrait'])) ?> par <?= htmlspecialchars($retrait['agent_prenom'] . ' ' . $retrait['agent_nom']) ?>.</span>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <div class="card">
            <h3>Fiche de l'étudiant</h3>
            <dl class="info-list">
                <dt>Nom complet</dt><dd><?= htmlspecialchars($demande['etudiant_prenom'] . ' ' . $demande['etudiant_nom']) ?></dd>
                <dt>Matricule</dt><dd class="mono"><?= htmlspecialchars($demande['matricule']) ?></dd>
                <dt>Filière et niveau</dt><dd><?= htmlspecialchars($demande['filiere'] . ', ' . $demande['niveau']) ?></dd>
                <dt>Email</dt><dd><?= htmlspecialchars($demande['email']) ?></dd>
                <dt>Date de retrait prévue</dt><dd><?= $demande['date_prevue_retrait'] ? date('d/m/Y', strtotime($demande['date_prevue_retrait'])) : '—' ?></dd>
            </dl>
        </div>

        <div class="card">
            <h3>Journal d'activité</h3>
            <div class="timeline">
                <?php foreach ($historique as $h): ?>
                <div class="timeline-item">
                    <div class="timeline-date"><?= date('d/m/Y à H:i', strtotime($h['date_changement'])) ?></div>
                    <div class="timeline-label"><?= ucfirst(str_replace('_', ' ', $h['nouveau_statut'])) ?></div>
                    <?php if ($h['agent_nom']): ?><div class="timeline-comment">Par l'agent <?= htmlspecialchars($h['agent_prenom'] . ' ' . $h['agent_nom']) ?></div><?php endif; ?>
                    <?php if ($h['commentaire']): ?><div class="timeline-comment"><?= htmlspecialchars($h['commentaire']) ?></div><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
