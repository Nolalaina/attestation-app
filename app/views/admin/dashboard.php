<div class="page-head">
    <div>
        <p class="page-eyebrow">Guichet et pilotage</p>
        <h1>Tableau de bord de la file d'attente</h1>
        <p class="page-sub">Vue d'ensemble de l'activité du bureau et gestion des demandes.</p>
    </div>
    <div class="col-actions">
        <a href="<?= APP_URL ?>/admin/ecranGuichet" target="_blank" rel="noopener" class="btn btn-accent">Écran guichet</a>
        <a href="<?= APP_URL ?>/admin/registre" class="btn btn-primary">Ouvrir le registre</a>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total des demandes</div>
        <div class="stat-value"><?= $total ?></div>
        <div class="stat-bar"><span style="width:100%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En attente</div>
        <div class="stat-value"><?= $stats['en_attente'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['en_attente']/$total*100) : 0 ?>%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En cours de traitement</div>
        <div class="stat-value"><?= $stats['en_cours'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['en_cours']/$total*100) : 0 ?>%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Prêtes pour retrait</div>
        <div class="stat-value"><?= $stats['traitee'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['traitee']/$total*100) : 0 ?>%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Documents retirés</div>
        <div class="stat-value"><?= $stats['retiree'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['retiree']/$total*100) : 0 ?>%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Refusées</div>
        <div class="stat-value"><?= $stats['refusee'] ?></div>
        <div class="stat-bar"><span style="width:<?= $total ? round($stats['refusee']/$total*100) : 0 ?>%"></span></div>
    </div>
</div>

<div class="section-title">
    <h2>Volume hebdomadaire</h2>
    <a href="<?= APP_URL ?>/admin/statistiques" class="btn btn-ghost btn-sm">Statistiques détaillées</a>
</div>

<div class="card">
    <?php if (empty($statsHebdo)): ?>
        <p>Pas encore de données pour établir une tendance.</p>
    <?php else: ?>
        <div class="chart-wrap">
            <?php
            $max = max(array_column($statsHebdo, 'total')) ?: 1;
            foreach ($statsHebdo as $s):
                $h = max(10, ($s['total'] / $max) * 120);
            ?>
            <div class="chart-cell">
                <div class="chart-col">
                    <div class="chart-bar" title="<?= $s['total'] ?> demande(s)" style="height:<?= $h ?>px;"></div>
                </div>
                <div class="chart-date"><?= date('d/m', strtotime($s['semaine_debut'])) ?></div>
                <div class="chart-total"><?= $s['total'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="section-title">
    <h2>Dernières demandes reçues</h2>
</div>

<?php if (empty($recentes)): ?>
    <div class="card empty-state"><div class="empty-ico"><i class="bi bi-inbox"></i></div><p>Aucune demande n'a encore été soumise.</p></div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead><tr><th>N° ticket</th><th>Étudiant</th><th>Type d'attestation</th><th>Date</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($recentes as $d): ?>
                <tr>
                    <td class="mono"><?= htmlspecialchars($d['code_demande']) ?></td>
                    <td><strong><?= htmlspecialchars($d['etudiant_prenom'] . ' ' . $d['etudiant_nom']) ?></strong></td>
                    <td><?= htmlspecialchars($d['type_nom']) ?></td>
                    <td><?= date('d/m/Y', strtotime($d['date_demande'])) ?></td>
                    <td><span class="badge badge-<?= $d['statut'] ?>"><?= ucfirst(str_replace('_', ' ', $d['statut'])) ?></span></td>
                    <td>
                        <a href="<?= APP_URL ?>/admin/detail/<?= $d['id'] ?>" class="btn btn-ghost btn-sm">Traiter</a>
                        <a href="<?= APP_URL ?>/admin/ticket/<?= $d['id'] ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-sm" title="Imprimer le ticket"><i class="bi bi-printer"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
