<div class="page-head">
    <div>
        <p class="page-eyebrow">Analyse & Performance</p>
        <h1>Statistiques de la file d'attente</h1>
        <p class="page-sub">Volume d'activité hebdomadaire et répartition des demandes par type et statut.</p>
    </div>
    <a href="<?= APP_URL ?>/admin/ecranGuichet" target="_blank" class="btn btn-accent"><i class="bi bi-tv-fill"></i> Écran Guichet (Hall)</a>
</div>

<div class="section-title"><h2><i class="bi bi-graph-up-arrow" style="color:var(--cyan)"></i> Activité hebdomadaire du bureau</h2></div>
<div class="table-wrap" style="margin-bottom:32px;">
    <table>
        <thead>
            <tr><th>Semaine du</th><th>Total Soumissions</th><th>Traitées / Prêtes</th><th>En cours de traitement</th><th>Refusées</th></tr>
        </thead>
        <tbody>
            <?php if (empty($statsHebdo)): ?>
                <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">Aucune donnée disponible.</td></tr>
            <?php endif; ?>
            <?php foreach ($statsHebdo as $s): ?>
            <tr>
                <td><strong><?= date('d/m/Y', strtotime($s['semaine_debut'])) ?></strong></td>
                <td><strong class="mono" style="font-size:16px;"><?= $s['total'] ?></strong></td>
                <td><span class="badge badge-traitee"><?= $s['traitees'] ?></span></td>
                <td><span class="badge badge-en_cours"><?= $s['en_cours'] ?></span></td>
                <td><span class="badge badge-refusee"><?= $s['refusees'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="two-col">
    <div>
        <div class="section-title"><h2><i class="bi bi-pie-chart-fill" style="color:var(--cyan)"></i> Demandes par type d'attestation</h2></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Type d'attestation</th><th>Nombre total</th></tr></thead>
                <tbody>
                    <?php foreach ($statsParType as $t): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($t['nom']) ?></strong></td>
                        <td><span class="mono" style="font-size:16px;color:var(--cyan);"><?= $t['total'] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="section-title"><h2><i class="bi bi-bar-chart-steps" style="color:var(--cyan)"></i> Répartition globale par statut</h2></div>
        <div class="card">
            <?php
            $labels = ['en_attente'=>'En attente','en_cours'=>'En cours','traitee'=>'Traitée','refusee'=>'Refusée','retiree'=>'Retirée'];
            $colorVar = ['en_attente'=>'--st-attente','en_cours'=>'--st-cours','traitee'=>'--st-traitee','refusee'=>'--st-refusee','retiree'=>'--st-retiree'];
            $totalAll = array_sum($statsStatut) ?: 1;
            foreach ($statsStatut as $key => $val):
                $pct = round($val / $totalAll * 100);
            ?>
            <div style="margin-bottom:18px;">
                <div style="display:flex;justify-content:space-between;font-size:14px;margin-bottom:6px;">
                    <span style="font-weight:700;"><?= $labels[$key] ?></span>
                    <strong style="color:var(<?= $colorVar[$key] ?>);"><?= $val ?> ticket(s) (<?= $pct ?>%)</strong>
                </div>
                <div style="height:8px;border-radius:999px;background:rgba(255,255,255,0.08);overflow:hidden;">
                    <div style="width:<?= $pct ?>%;height:100%;background:var(<?= $colorVar[$key] ?>);border-radius:999px;box-shadow:0 0 10px var(<?= $colorVar[$key] ?>);"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
