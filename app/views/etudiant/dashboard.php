<div class="page-head">
    <div>
        <p class="page-eyebrow">Tableau de Bord Étudiant</p>
        <h1>Bonjour, <?= htmlspecialchars(Auth::fullName()) ?> 👋</h1>
        <p class="page-sub">Bienvenue sur votre espace de gestion des tickets d'attestation.</p>
    </div>
    <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouvelle Demande</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Demandes</div>
        <div class="stat-value"><?= $stats['total'] ?></div>
        <div class="stat-bar"><span style="width:100%"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">En Cours de Traitement</div>
        <div class="stat-value" style="color:var(--st-cours)"><?= $stats['en_cours'] ?></div>
        <div class="stat-bar"><span style="width:<?= $stats['total'] ? round($stats['en_cours']/$stats['total']*100) : 0 ?>%;background:var(--st-cours)"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Attestations Prêtes / Retirées</div>
        <div class="stat-value" style="color:var(--st-traitee)"><?= $stats['traitees'] ?></div>
        <div class="stat-bar"><span style="width:<?= $stats['total'] ? round($stats['traitees']/$stats['total']*100) : 0 ?>%;background:var(--st-traitee)"></span></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Refusées</div>
        <div class="stat-value" style="color:var(--st-refusee)"><?= $stats['refusees'] ?></div>
        <div class="stat-bar"><span style="width:<?= $stats['total'] ? round($stats['refusees']/$stats['total']*100) : 0 ?>%;background:var(--st-refusee)"></span></div>
    </div>
</div>

<div class="section-title">
    <h2>Derniers tickets soumis</h2>
    <a href="<?= APP_URL ?>/etudiant/mesDemandes" class="btn btn-ghost btn-sm">Tout afficher →</a>
</div>

<?php if (empty($recentes)): ?>
    <div class="card empty-state">
        <div class="empty-ico"><i class="bi bi-inbox-fill"></i></div>
        <p>Aucune demande soumise récemment.</p>
        <a href="<?= APP_URL ?>/etudiant/nouvelleDemande" class="btn btn-accent">Faire une demande</a>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>N° Ticket</th>
                    <th>Type d'Attestation</th>
                    <th>Date Soumission</th>
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
                        <a href="<?= APP_URL ?>/etudiant/detail/<?= $d['id'] ?>" class="btn btn-ghost btn-sm">Suivre →</a>
                        <a href="<?= APP_URL ?>/etudiant/ticket/<?= $d['id'] ?>" target="_blank" class="btn btn-ghost btn-sm" title="Ticket"><i class="bi bi-printer"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
