<?php
$steps = ['en_attente', 'en_cours', 'traitee', 'retiree'];
$currentIndex = array_search($demande['statut'], $steps);
if ($demande['statut'] === 'refusee') { $currentIndex = -1; }
?>
<div class="page-head">
    <div>
        <p class="page-eyebrow">Suivi de Ticket en Direct</p>
        <h1 class="mono" style="font-size:32px;color:var(--cyan);"><?= htmlspecialchars($demande['code_demande']) ?></h1>
        <p class="page-sub">Ticket créé le <?= date('d/m/Y à H:i', strtotime($demande['date_demande'])) ?></p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="<?= APP_URL ?>/etudiant/ticket/<?= $demande['id'] ?>" target="_blank" class="btn btn-primary"><i class="bi bi-printer-fill"></i> Imprimer le Ticket</a>
        <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="btn btn-ghost">← Mes demandes</a>
    </div>
</div>

<div class="two-col">
    <div>
        <!-- Carte principale d'état du ticket -->
        <div class="card" style="display:flex;gap:24px;align-items:flex-start;margin-bottom:24px;">
            <div class="stamp st-<?= $demande['statut'] ?>"><?= strtoupper(str_replace('_', "\n", $demande['statut'])) ?></div>
            <div style="flex:1">
                <h3 style="font-size:20px;margin-bottom:6px;"><?= htmlspecialchars($demande['type_nom']) ?></h3>
                <p style="color:var(--text-muted);font-size:15px;margin-bottom:14px;"><?= htmlspecialchars($demande['objet']) ?></p>

                <?php if ($demande['statut'] !== 'refusee'): ?>
                <div class="progress-track">
                    <?php foreach ($steps as $i => $s): ?>
                        <div class="progress-step <?= $i <= $currentIndex ? 'done' : '' ?>" title="<?= ucfirst(str_replace('_', ' ', $s)) ?>"></div>
                    <?php endforeach; ?>
                </div>
                <p class="form-hint" style="margin-top:10px;font-size:13.5px;">
                    Étape actuelle dans la file : <strong style="color:#fff;"><?= ucfirst(str_replace('_', ' ', $demande['statut'])) ?></strong>
                    <?php if ($demande['date_prevue_retrait'] && $demande['statut'] !== 'retiree'): ?>
                        — Retrait prévu le <strong style="color:var(--cyan);"><?= date('d/m/Y', strtotime($demande['date_prevue_retrait'])) ?></strong>
                    <?php endif; ?>
                </p>
                <?php else: ?>
                    <div class="error-list" style="margin-top:14px;">
                        <strong>Motif du refus :</strong> <?= htmlspecialchars($demande['motif_refus'] ?? 'Non précisé') ?>
                    </div>
                <?php endif; ?>

                <?php if ($retrait): ?>
                    <div class="flash flash-success" style="margin-top:18px;margin-bottom:0;">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Document officiellement remis à <strong><?= htmlspecialchars($retrait['nom_receveur']) ?></strong> le <?= date('d/m/Y à H:i', strtotime($retrait['date_retrait'])) ?>.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($demande['observations']): ?>
        <div class="card" style="margin-bottom:24px;">
            <h4 style="font-size:14px;color:var(--text-subtle);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px;">Observations soumises</h4>
            <p style="margin:0;color:var(--text-main);font-size:14.5px;"><?= htmlspecialchars($demande['observations']) ?></p>
        </div>
        <?php endif; ?>
    </div>

    <div>
        <!-- Historique chronologique des événements -->
        <div class="card">
            <h3 style="font-size:17px;margin-bottom:20px;"><i class="bi bi-clock-history" style="color:var(--cyan)"></i> Journal de suivi du ticket</h3>
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
