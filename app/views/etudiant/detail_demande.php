<?php
$steps = ['en_attente', 'en_cours', 'traitee', 'retiree'];
$currentIndex = array_search($demande['statut'], $steps);
if ($demande['statut'] === 'refusee') { $currentIndex = -1; }
?>
<div class="page-head">
    <div>
        <p class="page-eyebrow">Suivi de ticket</p>
        <h1 class="mono"><?= htmlspecialchars($demande['code_demande']) ?></h1>
        <p class="page-sub">Ticket créé le <?= date('d/m/Y à H:i', strtotime($demande['date_demande'])) ?></p>
    </div>
    <div class="col-actions">
        <a href="<?= APP_URL ?>/etudiant/ticket/<?= $demande['id'] ?>" target="_blank" rel="noopener" class="btn btn-primary">Imprimer le ticket</a>
        <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="btn btn-ghost">Mes demandes</a>
    </div>
</div>

<div class="two-col">
    <div>
        <div class="card row-between">
            <div class="stamp st-<?= $demande['statut'] ?>"><?= strtoupper(str_replace('_', "\n", $demande['statut'])) ?></div>
            <div class="grow">
                <h3><?= htmlspecialchars($demande['type_nom']) ?></h3>
                <p class="page-sub"><?= htmlspecialchars($demande['objet']) ?></p>

                <?php if ($demande['statut'] !== 'refusee'): ?>
                <div class="progress-track">
                    <?php foreach ($steps as $i => $s): ?>
                        <div class="progress-step <?= $i <= $currentIndex ? 'done' : '' ?>" title="<?= ucfirst(str_replace('_', ' ', $s)) ?>"></div>
                    <?php endforeach; ?>
                </div>
                <p class="form-hint">Étape actuelle dans la file : <strong><?= ucfirst(str_replace('_', ' ', $demande['statut'])) ?></strong>
                    <?php if ($demande['date_prevue_retrait'] && $demande['statut'] !== 'retiree'): ?>
                        (retrait prévu le <strong><?= date('d/m/Y', strtotime($demande['date_prevue_retrait'])) ?></strong>)
                    <?php endif; ?>
                </p>
                <?php else: ?>
                    <div class="error-list">
                        <strong>Motif du refus :</strong> <?= htmlspecialchars($demande['motif_refus'] ?? 'Non précisé') ?>
                    </div>
                <?php endif; ?>

                <?php if ($retrait): ?>
                    <div class="flash flash-success">
                        <span>Document officiellement remis à <strong><?= htmlspecialchars($retrait['nom_receveur']) ?></strong> le <?= date('d/m/Y à H:i', strtotime($retrait['date_retrait'])) ?>.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($demande['observations']): ?>
        <div class="card">
            <h4>Observations soumises</h4>
            <p><?= htmlspecialchars($demande['observations']) ?></p>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <div class="card">
            <h3>Journal de suivi du ticket</h3>
            <div class="timeline">
                <?php foreach ($historique as $h): ?>
                <div class="timeline-item">
                    <div class="timeline-date"><?= date('d/m/Y à H:i', strtotime($h['date_changement'])) ?></div>
                    <div class="timeline-label"><?= ucfirst(str_replace('_', ' ', $h['nouveau_statut'])) ?></div>
                    <?php if ($h['commentaire']): ?>
                        <div class="timeline-comment"><?= htmlspecialchars($h['commentaire']) ?></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
