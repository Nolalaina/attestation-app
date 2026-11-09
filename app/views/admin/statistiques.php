<div class="page-head">
    <div>
        <p class="page-eyebrow">Analyse et performance</p>
        <h1>Statistiques de la file d'attente</h1>
        <p class="page-sub">Volume d'activité hebdomadaire et répartition des demandes par type et statut.</p>
    </div>
    <a href="<?= APP_URL ?>/admin/ecranGuichet" target="_blank" rel="noopener" class="btn btn-accent">Écran guichet</a>
</div>

<div class="section-title"><h2>Activité hebdomadaire du bureau</h2></div>
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>Semaine du</th><th>Total des soumissions</th><th>Traitées et prêtes</th><th>En cours de traitement</th><th>Refusées</th></tr>
        </thead>
        <tbody>
            <?php if (empty($statsHebdo)): ?>
                <tr><td colspan="5">Aucune donnée disponible.</td></tr>
            <?php endif; ?>
            <?php foreach ($statsHebdo as $s): ?>
            <tr>
                <td><strong><?= date('d/m/Y', strtotime($s['semaine_debut'])) ?></strong></td>
                <td><strong class="mono"><?= $s['total'] ?></strong></td>
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
        <div class="section-title"><h2>Demandes par type d'attestation</h2></div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Type d'attestation</th><th>Nombre total</th></tr></thead>
                <tbody>
                    <?php foreach ($statsParType as $t): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($t['nom']) ?></strong></td>
                        <td><span class="mono"><?= $t['total'] ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <div class="section-title"><h2>Répartition globale par statut</h2></div>
        <div class="card">
            <?php
            $labels = ['en_attente'=>'En attente','en_cours'=>'En cours','traitee'=>'Traitée','refusee'=>'Refusée','retiree'=>'Retirée'];
            $totalAll = array_sum($statsStatut) ?: 1;
            foreach ($statsStatut as $key => $val):
                $pct = round($val / $totalAll * 100);
            ?>
            <div class="bar-row">
                <div class="bar-legend">
                    <span style="font-weight:500;"><?= $labels[$key] ?></span>
                    <strong class="mono"><?= $val ?> ticket(s) (<?= $pct ?>%)</strong>
                </div>
                <div class="chart-track">
                    <span class="chart-fill" style="width:<?= $pct ?>%;"></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
