<div class="page-head">
    <div>
        <p class="page-eyebrow">Traitement Guichet</p>
        <h1 class="mono" style="font-size:32px;color:var(--cyan);"><?= htmlspecialchars($demande['code_demande']) ?></h1>
        <p class="page-sub">Soumise le <?= date('d/m/Y à H:i', strtotime($demande['date_demande'])) ?></p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="<?= APP_URL ?>/admin/ticket/<?= $demande['id'] ?>" target="_blank" class="btn btn-accent"><i class="bi bi-printer-fill"></i> Imprimer le Ticket</a>
        <a href="<?= APP_URL ?>/admin/registre" class="btn btn-ghost">← Retour au registre</a>
    </div>
</div>

<div class="two-col">
    <div>
        <!-- Carte de statut du ticket -->
        <div class="card" style="display:flex;gap:24px;align-items:flex-start;margin-bottom:24px;">
            <div class="stamp st-<?= $demande['statut'] ?>"><?= strtoupper(str_replace('_', "\n", $demande['statut'])) ?></div>
            <div style="flex:1">
                <h3 style="font-size:18px;margin-bottom:4px;"><?= htmlspecialchars($demande['type_nom']) ?></h3>
                <p style="color:var(--text-muted);font-size:14.5px;margin-bottom:12px;"><?= htmlspecialchars($demande['objet']) ?></p>

                <?php if ($demande['observations']): ?>
                    <div style="font-size:13.5px;background:rgba(255,255,255,0.04);padding:12px 16px;border-radius:10px;border-left:3px solid var(--cyan);margin-top:12px;">
                        <strong>Observations de l'étudiant :</strong> <?= htmlspecialchars($demande['observations']) ?>
                    </div>
                <?php endif; ?>

                <?php if ($demande['statut'] === 'refusee'): ?>
                    <div class="error-list" style="margin-top:14px;"><strong>Motif du refus :</strong> <?= htmlspecialchars($demande['motif_refus']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!in_array($demande['statut'], ['retiree'], true)): ?>
        <div class="card" style="margin-bottom:24px;">
            <h3 style="font-size:16px;margin-bottom:16px;"><i class="bi bi-pencil-square" style="color:var(--cyan)"></i> Mettre à jour le statut dans la file</h3>
            <form method="POST" action="<?= APP_URL ?>/admin/changerStatut/<?= $demande['id'] ?>">
                <div class="form-group">
                    <label for="statut">Nouveau statut</label>
                    <select id="statut" name="statut" data-statut-select="#motif-box">
                        <?php if ($demande['statut'] === 'en_attente'): ?>
                            <option value="en_cours">⚙️ Prendre en charge (En cours)</option>
                        <?php endif; ?>
                        <?php if (in_array($demande['statut'], ['en_attente', 'en_cours'], true)): ?>
                            <option value="traitee">✅ Marquer comme traitée & prête au guichet</option>
                            <option value="refusee">❌ Refuser la demande</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group" id="motif-box" style="display:none;">
                    <label for="commentaire">Motif du refus</label>
                    <textarea id="commentaire" name="commentaire" placeholder="Expliquez la raison du refus pour l'étudiant..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Valider le changement</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($demande['statut'] === 'traitee'): ?>
        <div class="card" style="border-color:var(--st-traitee);background:rgba(16,185,129,0.08);margin-bottom:24px;">
            <h3 style="font-size:16px;color:#34d399;"><i class="bi bi-gift-fill"></i> Document Prêt pour le Retrait au Guichet</h3>
            <p style="font-size:14px;color:var(--text-muted);margin-bottom:16px;">L'attestation a été imprimée et visée. Enregistrez le retrait dès que l'étudiant se présente.</p>
            <a href="<?= APP_URL ?>/admin/retrait/<?= $demande['id'] ?>" class="btn btn-accent"><i class="bi bi-box-arrow-up-right"></i> Enregistrer la remise du document</a>
        </div>
        <?php endif; ?>

        <?php if ($retrait): ?>
        <div class="flash flash-success">
            <i class="bi bi-shield-check"></i>
            <span>Document remis à <strong><?= htmlspecialchars($retrait['nom_receveur']) ?></strong> le <?= date('d/m/Y à H:i', strtotime($retrait['date_retrait'])) ?> par <?= htmlspecialchars($retrait['agent_prenom'] . ' ' . $retrait['agent_nom']) ?>.</span>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <!-- Fiche étudiant -->
        <div class="card" style="margin-bottom:24px;">
            <h3 style="font-size:16px;margin-bottom:16px;"><i class="bi bi-person-lines-fill" style="color:var(--cyan)"></i> Fiche de l'étudiant</h3>
            <dl class="info-list">
                <dt>Nom complet</dt><dd><?= htmlspecialchars($demande['etudiant_prenom'] . ' ' . $demande['etudiant_nom']) ?></dd>
                <dt>Matricule</dt><dd class="mono"><?= htmlspecialchars($demande['matricule']) ?></dd>
                <dt>Filière / Niveau</dt><dd><?= htmlspecialchars($demande['filiere'] . ' — ' . $demande['niveau']) ?></dd>
                <dt>Email</dt><dd><?= htmlspecialchars($demande['email']) ?></dd>
                <dt>Date de retrait prévue</dt><dd><?= $demande['date_prevue_retrait'] ? date('d/m/Y', strtotime($demande['date_prevue_retrait'])) : '—' ?></dd>
            </dl>
        </div>

        <!-- Historique -->
        <div class="card">
            <h3 style="font-size:16px;margin-bottom:16px;"><i class="bi bi-clock-history" style="color:var(--cyan)"></i> Journal d'activité</h3>
            <div class="timeline">
                <?php foreach ($historique as $h): ?>
                <div class="timeline-item">
                    <div class="timeline-date"><?= date('d/m/Y à H:i', strtotime($h['date_changement'])) ?></div>
                    <div class="timeline-label"><?= ucfirst(str_replace('_', ' ', $h['nouveau_statut'])) ?></div>
                    <?php if ($h['agent_nom']): ?><div class="timeline-comment">Par agent <?= htmlspecialchars($h['agent_prenom'] . ' ' . $h['agent_nom']) ?></div><?php endif; ?>
                    <?php if ($h['commentaire']): ?><div class="timeline-comment"><?= htmlspecialchars($h['commentaire']) ?></div><?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
