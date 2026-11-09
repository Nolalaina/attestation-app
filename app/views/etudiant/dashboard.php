<div class="page-head">
    <div>
        <p class="page-eyebrow">Tableau de bord étudiant</p>
        <h1>Bonjour, <?= htmlspecialchars(Auth::fullName()) ?></h1>
        <p class="page-sub">Bienvenue sur votre espace de gestion des demandes d'attestation.</p>
    </div>
    <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="btn btn-primary">Nouvelle demande</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total des demandes</div>
        <div class="stat-value"><?= $stats['total'] ?></div>
        <div class="stat-bar"><span style="width:100%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En cours de traitement</div>
        <div class="stat-value"><?= $stats['en_cours'] ?></div>
        <div class="stat-bar"><span style="width:<?= $stats['total'] ? round($stats['en_cours']/$stats['total']*100) : 0 ?>%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Prêtes ou retirées</div>
        <div class="stat-value"><?= $stats['traitees'] ?></div>
        <div class="stat-bar"><span style="width:<?= $stats['total'] ? round($stats['traitees']/$stats['total']*100) : 0 ?>%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Refusées</div>
        <div class="stat-value"><?= $stats['refusees'] ?></div>
        <div class="stat-bar"><span style="width:<?= $stats['total'] ? round($stats['refusees']/$stats['total']*100) : 0 ?>%"></span></div>
    </div>
</div>

<div class="section-title">
    <h2>Derniers tickets soumis</h2>
    <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="btn btn-ghost btn-sm">Tout afficher</a>
</div>

<?php if (empty($recentes)): ?>
    <div class="card empty-state">
        <div class="empty-ico"><i class="bi bi-inbox"></i></div>
        <p>Aucune demande soumise récemment.</p>
        <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="btn btn-accent">Faire une demande</a>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>N° ticket</th>
                    <th>Type d'attestation</th>
                    <th>Date de soumission</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentes as $d): ?>
                <tr>
                    <td class="mono"><?= htmlspecialchars($d['code_demande']) ?></td>
                    <td><strong><?= htmlspecialchars($d['type_nom']) ?></strong></td>
                    <td><?= date('d/m/Y', strtotime($d['date_demande'])) ?></td>
                    <td><span class="badge badge-<?= $d['statut'] ?>"><?= ucfirst(str_replace('_', ' ', $d['statut'])) ?></span></td>
                    <td>
                        <a href="<?= APP_URL ?>/etudiant/detail/<?= $d['id'] ?>" class="btn btn-ghost btn-sm">Suivre</a>
                        <a href="<?= APP_URL ?>/etudiant/ticket/<?= $d['id'] ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-sm" title="Ticket"><i class="bi bi-printer"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
